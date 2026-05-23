<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static ?string $navigationLabel = 'Regions';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('latitude')->numeric()->required(),
            Forms\Components\TextInput::make('longitude')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->poll('30s')
            ->defaultSort('name')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('latitude')->sortable(),
                Tables\Columns\TextColumn::make('longitude')->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')->label('Users')->badge()->color('info')->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Region $record, Tables\Actions\DeleteAction $action) {
                        if ($record->users()->exists() || $record->requests()->exists() || $record->addresses()->exists()) {
                            Notification::make()
                                ->title('Cannot delete: region has related records')
                                ->danger()->send();
                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit'   => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
