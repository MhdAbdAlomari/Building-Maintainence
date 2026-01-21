<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Models\Address;
use App\Models\Request as WorkRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class RequestResource extends Resource
{
    protected static ?string $model = WorkRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Requests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Request')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->required(),

                        //  Tenant أولاً (حتى نفلتر العناوين بناءً عليه)
                        Forms\Components\Select::make('tenant_id')
                            ->relationship('tenant', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set) {
                                // لما يغير tenant نمسح العنوان والمنطقة
                                $set('address_id', null);
                                $set('region_id', null);
                            }),

                        //  Address بدل address_text
                        Forms\Components\Select::make('address_id')
                            ->label('Address')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(function (Get $get) {
                                $tenantId = $get('tenant_id');
                                if (! $tenantId) {
                                    return [];
                                }

                                // عدّل اسم الحقل إذا عندك غير address_text داخل جدول addresses
                                return Address::query()
                                    ->where('user_id', $tenantId)
                                    ->orderByDesc('is_default')
                                    ->orderBy('id', 'desc')
                                    ->pluck('address_text', 'id')
                                    ->toArray();
                            })
                            ->reactive()
                            ->afterStateUpdated(function (?string $state, Set $set) {
                                if (! $state) {
                                    $set('region_id', null);
                                    return;
                                }

                                $addr = Address::query()->find($state);
                                $set('region_id', $addr?->region_id);
                            }),

                        //  region_id يجي تلقائياً من العنوان (readonly)
                        Forms\Components\Select::make('region_id')
                            ->relationship('region', 'name')
                            ->required()
                            ->disabled()
                            ->dehydrated(), // مهم: يخليه ينحفظ بالـ DB حتى وهو disabled

                        Forms\Components\Select::make('service_id')
                            ->relationship('service', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('technician_id')
                            ->relationship('technician', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'    => 'Pending',
                                'accepted'   => 'Accepted',
                                'on_the_way' => 'Processing',
                                'complete'   => 'Done',
                                'canceled'   => 'Canceled',
                            ])
                            ->required(),

                        Forms\Components\DatePicker::make('scheduled_date')
                            ->required(),

                        Forms\Components\TimePicker::make('scheduled_time')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Tenant')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->limit(22),

                //  Address column
                Tables\Columns\TextColumn::make('address.address_text')
                    ->label('Address')
                    ->searchable()
                    ->limit(26)
                    ->tooltip(fn ($record) => $record->address?->address_text)
                    ->toggleable(),

                //  Service badge colors
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service')
                    ->sortable()
                    ->badge()
                    ->color(fn (?string $state): string => match (strtolower($state ?? '')) {
                        'plumbing'   => 'info',
                        'electrical' => 'warning',
                        'painting'   => 'success',
                        'hvac'       => 'danger',
                        'carpentry'  => 'gray',
                        default      => 'primary',
                    }),
         

                Tables\Columns\TextColumn::make('region.name')
                    ->label('Region')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending'    => 'Pending',
                        'accepted'   => 'Accepted',
                        'on_the_way' => 'Processing',
                        'complete'   => 'Done',
                        'canceled'   => 'Canceled',
                        default      => ucfirst(str_replace('_', ' ', $state)),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending'    => 'warning',
                        'accepted'   => 'info',
                        'on_the_way' => 'gray',
                        'complete'   => 'success',
                        'canceled'   => 'danger',
                        default      => 'gray',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(24)
                    ->tooltip(fn ($record) => $record->title),

                Tables\Columns\TextColumn::make('scheduled_date')
                    ->label('Scheduled')
                    ->date('M d, Y')
                    ->sortable()
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('scheduled_time')
                    ->label('Time')
                    ->time('H:i')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Technician')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(18),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'accepted'   => 'Accepted',
                        'on_the_way' => 'Processing',
                        'complete'   => 'Done',
                        'canceled'   => 'Canceled',
                    ]),

                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Service')
                    ->relationship('service', 'name'),

                Tables\Filters\SelectFilter::make('region_id')
                    ->label('Region')
                    ->relationship('region', 'name'),

                // اختياري: فلتر حسب العنوان
                Tables\Filters\SelectFilter::make('address_id')
                    ->label('Address')
                    ->relationship('address', 'address_text'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit'   => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
