<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\Address;
use App\Models\Request as WorkRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RequestResource extends Resource
{
    protected static ?string $model = WorkRequest::class;

    protected static ?string $navigationLabel = 'Requests';
    protected static ?string $navigationGroup = 'Operations';
    protected static ?int $navigationSort = 1;

    protected static array $statuses = [
        'pending'                 => 'Pending',
        'estimate_price'          => 'Estimate Price',
        'confirmed'               => 'Confirmed',
        'processing'              => 'Processing',
        'awaiting_final_approval' => 'Awaiting Final Approval',
        'completed'               => 'Completed',
        'rejected'                => 'Rejected',
        'cancelled'               => 'Cancelled',
    ];

    public static function statusColor(string $state): string
    {
        return match ($state) {
            'pending'                 => 'warning',
            'estimate_price'          => 'info',
            'confirmed'               => 'primary',
            'processing'              => 'info',
            'awaiting_final_approval' => 'warning',
            'completed'               => 'success',
            'rejected'                => 'danger',
            'cancelled'               => 'gray',
            default                   => 'gray',
        };
    }

    public static function statusIcon(string $state): string
    {
        return match ($state) {
            'pending'                 => 'heroicon-m-clock',
            'estimate_price'          => 'heroicon-m-calculator',
            'confirmed'               => 'heroicon-m-shield-check',
            'processing'              => 'heroicon-m-arrow-path',
            'awaiting_final_approval' => 'heroicon-m-eye',
            'completed'               => 'heroicon-m-check-circle',
            'rejected'                => 'heroicon-m-x-circle',
            'cancelled'               => 'heroicon-m-no-symbol',
            default                   => 'heroicon-m-question-mark-circle',
        };
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Request')->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->rows(3)->required()->columnSpanFull(),

                Forms\Components\Select::make('tenant_id')
                    ->relationship('tenant', 'name', fn (Builder $query) => $query->where('role', 'tenant'))
                    ->searchable()->preload()->required()
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('address_id', null);
                    }),

                Forms\Components\Select::make('address_id')
                    ->label('Address')->required()->searchable()->preload()
                    ->options(function (Get $get) {
                        $tenantId = $get('tenant_id');
                        if (! $tenantId) {
                            return [];
                        }
                        return Address::query()
                            ->where('user_id', $tenantId)
                            ->orderByDesc('is_default')
                            ->orderBy('id', 'desc')
                            ->pluck('address_text', 'id')
                            ->toArray();
                    }),

                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')->required()->searchable()->preload(),

                Forms\Components\Select::make('technician_id')
                    ->relationship('technician', 'name', fn (Builder $query) => $query->where('role', 'technician'))
                    ->searchable()->preload()->nullable(),

                Forms\Components\Select::make('status')
                    ->options(self::$statuses)
                    ->required()->default('pending'),

                Forms\Components\DatePicker::make('scheduled_date')->required(),
                Forms\Components\TimePicker::make('scheduled_time')->required(),
            ])->columns(2),

            Forms\Components\Section::make('Pricing')->schema([
                Forms\Components\TextInput::make('estimated_price')->numeric()->prefix('SYP'),
                Forms\Components\TextInput::make('final_price_syp')->label('Final Price')->numeric()->prefix('SYP'),
                Forms\Components\Textarea::make('estimate_note')->columnSpanFull(),
                Forms\Components\Toggle::make('is_paid'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->poll('30s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable()->alignCenter(),

                Tables\Columns\TextColumn::make('tenant.name')->label('Tenant')
                    ->searchable()->sortable()->weight(FontWeight::Medium)->limit(22),

                Tables\Columns\TextColumn::make('technician.name')->label('Technician')
                    ->searchable()->sortable()->placeholder('—')->limit(22),

                Tables\Columns\TextColumn::make('service.name')->label('Service')
                    ->sortable()->badge()->color('primary'),

                Tables\Columns\TextColumn::make('title')->searchable()->limit(26)
                    ->tooltip(fn ($record) => $record->title),

                Tables\Columns\TextColumn::make('status')
                    ->badge()->alignCenter()
                    ->formatStateUsing(fn (string $state) => ucwords(str_replace('_', ' ', $state)))
                    ->icon(fn (string $state): ?string => self::statusIcon($state))
                    ->color(fn (string $state): string => self::statusColor($state)),

                Tables\Columns\TextColumn::make('estimated_price')->numeric()->sortable()->alignEnd(),
                Tables\Columns\TextColumn::make('final_price_syp')->label('Final')->numeric()->sortable()->alignEnd(),

                Tables\Columns\IconColumn::make('is_paid')->boolean()->alignCenter(),

                Tables\Columns\TextColumn::make('scheduled_date')->date('M d, Y')->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')->since()->color('gray')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(self::$statuses),
                Tables\Filters\SelectFilter::make('service_id')->label('Service')->relationship('service', 'name'),
                Tables\Filters\TernaryFilter::make('is_paid')->label('Paid'),
                Tables\Filters\Filter::make('created_between')
                    ->label('Created Date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from']  ?? null, fn (Builder $q, $v) => $q->whereDate('created_at', '>=', $v))
                            ->when($data['until'] ?? null, fn (Builder $q, $v) => $q->whereDate('created_at', '<=', $v));
                    }),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Request')
                ->icon('heroicon-m-clipboard-document-list')
                ->schema([
                    Infolists\Components\TextEntry::make('id')->label('#'),
                    Infolists\Components\TextEntry::make('title'),
                    Infolists\Components\TextEntry::make('description')->columnSpanFull(),
                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->formatStateUsing(fn (string $state) => ucwords(str_replace('_', ' ', $state)))
                        ->icon(fn (string $state): string => self::statusIcon($state))
                        ->color(fn (string $state): string => self::statusColor($state)),
                    Infolists\Components\TextEntry::make('scheduled_date')->date('M d, Y'),
                    Infolists\Components\TextEntry::make('scheduled_time')->time('H:i'),
                ])->columns(3),

            Infolists\Components\Section::make('People')
                ->icon('heroicon-m-user-group')
                ->schema([
                    Infolists\Components\TextEntry::make('tenant.name')->label('Tenant'),
                    Infolists\Components\TextEntry::make('tenant.phone')->label('Tenant Phone'),
                    Infolists\Components\TextEntry::make('technician.name')->label('Technician')->placeholder('—'),
                    Infolists\Components\TextEntry::make('technician.phone')->label('Technician Phone')->placeholder('—'),
                    Infolists\Components\TextEntry::make('service.name')->label('Service')->badge()->color('primary'),
                    Infolists\Components\TextEntry::make('address.address_text')->label('Address'),
                ])->columns(3),

            Infolists\Components\Section::make('Pricing & Payment')
                ->icon('heroicon-m-banknotes')
                ->schema([
                Infolists\Components\TextEntry::make('estimated_price')->numeric()->suffix(' SYP'),
                Infolists\Components\TextEntry::make('additions_total')->label('Additions Total')->numeric()->suffix(' SYP'),
                Infolists\Components\TextEntry::make('final_price_syp')->label('Final Price')->numeric()->suffix(' SYP'),
                Infolists\Components\IconEntry::make('is_paid')->boolean(),
                Infolists\Components\TextEntry::make('paid_at')->dateTime()->placeholder('—'),
                Infolists\Components\TextEntry::make('estimate_note')->columnSpanFull()->placeholder('—'),
            ])->columns(3),

            Infolists\Components\Section::make('Timeline')
                ->icon('heroicon-m-clock')
                ->schema([
                    Infolists\Components\TextEntry::make('estimated_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('confirmed_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('processing_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('final_approval_requested_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('completed_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('rejected_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('cancelled_at')->dateTime()->placeholder('—'),
                    Infolists\Components\TextEntry::make('cancellation_reason')->placeholder('—'),
                ])->columns(2)->collapsed(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AdditionsRelationManager::class,
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'view'   => Pages\ViewRequest::route('/{record}'),
            'edit'   => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
