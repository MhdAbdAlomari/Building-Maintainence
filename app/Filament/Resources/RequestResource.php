<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Models\Request;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon  = 'heroicon-o-clipboard-document';
    protected static ?string $navigationLabel = 'Requests';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // المستأجر
                Forms\Components\Select::make('tenant_id')
                    ->relationship('tenant', 'name')
                    ->label('Tenant')
                    ->searchable()
                    ->required(),

                // الفني (ممكن يكون null)
                Forms\Components\Select::make('technician_id')
                    ->relationship('technician', 'name')
                    ->label('Technician')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')
                    ->label('Service')
                    ->required(),

                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name')
                    ->label('Region')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending'    => 'Pending',
                        'accepted'   => 'Accepted',
                        'on_the_way' => 'On the way',
                        'completed'  => 'Completed',
                        'canceled'   => 'Canceled',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('address_text')
                    ->label('Address')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('scheduled_date')
                    ->label('Scheduled date')
                    ->nullable(),

                Forms\Components\TimePicker::make('scheduled_time')
                    ->label('Scheduled time')
                    ->nullable(),

                Forms\Components\Textarea::make('cancellation_reason')
                    ->label('Cancellation reason')
                    ->columnSpanFull()
                    ->nullable(),

                Forms\Components\DateTimePicker::make('canceled_at')
                    ->label('Canceled at')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Tenant')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Technician')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service')
                    ->sortable(),

                Tables\Columns\TextColumn::make('region.name')
                    ->label('Region')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('scheduled_date')
                    ->label('Scheduled date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('scheduled_time')
                    ->label('Time'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'accepted'   => 'Accepted',
                        'on_the_way' => 'On the way',
                        'completed'  => 'Completed',
                        'canceled'   => 'Canceled',
                    ]),

                SelectFilter::make('service')
                    ->relationship('service', 'name')
                    ->label('Service'),

                SelectFilter::make('region')
                    ->relationship('region', 'name')
                    ->label('Region'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // لو ما بدك الأدمن يحذف الطلبات، لا تضيف DeleteAction هنا
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
