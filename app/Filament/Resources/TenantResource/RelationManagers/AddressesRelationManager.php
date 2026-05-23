<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';
    protected static ?string $title = 'Addresses';
    protected static ?string $recordTitleAttribute = 'address_text';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')->maxLength(255),
            Forms\Components\TextInput::make('address_text')->maxLength(255),
            Forms\Components\Select::make('region_id')->relationship('region', 'name')->searchable(),
            Forms\Components\TextInput::make('latitude')->numeric()->required(),
            Forms\Components\TextInput::make('longitude')->numeric()->required(),
            Forms\Components\Toggle::make('is_default'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('address_text')->limit(36)->searchable(),
                Tables\Columns\TextColumn::make('region.name')->label('Region'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
                Tables\Columns\IconColumn::make('is_default')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
