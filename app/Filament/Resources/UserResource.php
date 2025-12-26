<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon  = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required(),

                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name')
                    ->label('Region')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('role')
                    ->options([
                        'tenant'     => 'Tenant',
                        'technician' => 'Technician',
                        'admin'      => 'Admin',
                    ])
                    ->required()
                    ->default('technician'),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),

                // كلمة المرور
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $context) => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) =>
                        filled($state) ? Hash::make($state) : null
                    )
                    ->dehydrated(fn ($state) => filled($state))
                    ->label('Password'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'success' => 'admin',
                        'info'    => 'technician',
                        'gray'    => 'tenant',
                    ]),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'tenant'     => 'Tenant',
                        'technician' => 'Technician',
                        'admin'      => 'Admin',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
