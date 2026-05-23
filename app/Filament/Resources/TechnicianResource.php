<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnicianResource\Pages;
use App\Filament\Resources\TechnicianResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class TechnicianResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Technicians';
    protected static ?string $modelLabel      = 'Technician';
    protected static ?string $pluralModelLabel = 'Technicians';
    protected static ?string $navigationGroup = 'Users Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'technicians';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'technician')
            ->with(['technicianDetail.service', 'wallet']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Account')->schema([
                Forms\Components\Hidden::make('role')->default('technician'),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('phone')->tel()->required(),
                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name')
                    ->label('Region')->searchable()->preload()->nullable(),
                Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                Forms\Components\TextInput::make('password')
                    ->password()->revealable()
                    ->required(fn (string $context) => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state)),
            ])->columns(2),

            Forms\Components\Section::make('Technician Details')->schema([
                Forms\Components\Select::make('technicianDetail.service_id')
                    ->label('Service')
                    ->relationship('technicianDetail.service', 'name')
                    ->searchable()->preload(),
                Forms\Components\TextInput::make('technicianDetail.years_of_experience')
                    ->label('Years of experience')->numeric()->minValue(0)->maxValue(60),
                Forms\Components\TextInput::make('technicianDetail.max_distance_km')
                    ->label('Max distance (km)')->numeric()->minValue(0)->maxValue(500),
                Forms\Components\Textarea::make('technicianDetail.skills_description')
                    ->label('Skills / description')->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('technicianDetail.service.name')
                    ->label('Service')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wallet.balance')
                    ->label('Wallet (SYP)')
                    ->numeric()
                    ->sortable()
                    ->default(0),
                Tables\Columns\TextColumn::make('technicianDetail.max_distance_km')
                    ->label('Max KM')->alignCenter()->sortable(),
                Tables\Columns\TextColumn::make('assigned_requests_count')
                    ->label('Completed')
                    ->counts(['assignedRequests' => fn ($q) => $q->where('status', 'completed')])
                    ->badge()
                    ->color('success')
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service')
                    ->relationship('technicianDetail.service', 'name'),
                Tables\Filters\SelectFilter::make('region_id')
                    ->label('Region')
                    ->relationship('region', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\Filter::make('setup_complete')
                    ->label('Setup complete')
                    ->query(fn (Builder $q) => $q->whereHas('technicianDetail', fn ($qq) => $qq->whereNotNull('max_distance_km'))
                                                  ->whereHas('addresses')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            Infolists\Components\Section::make('Profile')->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('email')->copyable(),
                Infolists\Components\TextEntry::make('phone'),
                Infolists\Components\TextEntry::make('region.name')->label('Region'),
                Infolists\Components\IconEntry::make('is_active')->boolean(),
                Infolists\Components\TextEntry::make('created_at')->dateTime(),
            ])->columns(2),

            Infolists\Components\Section::make('Technician Details')->schema([
                Infolists\Components\TextEntry::make('technicianDetail.service.name')->label('Service'),
                Infolists\Components\TextEntry::make('technicianDetail.years_of_experience')->label('Years'),
                Infolists\Components\TextEntry::make('technicianDetail.max_distance_km')->label('Max KM')->suffix(' km'),
                Infolists\Components\TextEntry::make('technicianDetail.skills_description')->label('Skills')->columnSpanFull(),
            ])->columns(3),

            Infolists\Components\Section::make('Wallet')->schema([
                Infolists\Components\TextEntry::make('wallet.balance')->label('Balance')->numeric()->suffix(' SYP'),
                Infolists\Components\TextEntry::make('wallet.currency')->label('Currency'),
                Infolists\Components\TextEntry::make('wallet.updated_at')->label('Updated')->dateTime(),
            ])->columns(3),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AssignedRequestsRelationManager::class,
            RelationManagers\WalletTransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTechnicians::route('/'),
            'create' => Pages\CreateTechnician::route('/create'),
            'view'   => Pages\ViewTechnician::route('/{record}'),
            'edit'   => Pages\EditTechnician::route('/{record}/edit'),
        ];
    }
}
