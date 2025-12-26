<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnicianDetailResource\Pages;
use App\Models\TechnicianDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class TechnicianDetailResource extends Resource
{
    protected static ?string $model = TechnicianDetail::class;

    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Technicians';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // اختيار المستخدم الفني (من جدول users حيث role = technician)
                Forms\Components\Select::make('user_id')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) =>
                            $query->where('role', 'technician')
                    )
                    ->label('Technician (User)')
                    ->searchable()
                    ->required(),

                // الخدمة التي يعمل بها الفني
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')
                    ->label('Service')
                    ->required(),

                Forms\Components\TextInput::make('years_of_experience')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(60)
                    ->label('Years of experience')
                    ->nullable(),

                Forms\Components\Textarea::make('skills_description')
                    ->label('Skills / description')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Technician')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service')
                    ->sortable(),

                Tables\Columns\TextColumn::make('years_of_experience')
                    ->label('Years')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.is_active')
                    ->label('Active')
                    ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                    ->badge()
                    ->colors([
                        'success' => fn ($state) => $state,
                        'danger'  => fn ($state) => ! $state,
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // فلتر حسب الخدمة
                SelectFilter::make('service')
                    ->relationship('service', 'name')
                    ->label('Service'),

                // فلتر حسب حالة التفعيل من جدول users
              
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTechnicianDetails::route('/'),
            'create' => Pages\CreateTechnicianDetail::route('/create'),
            'edit'   => Pages\EditTechnicianDetail::route('/{record}/edit'),
        ];
    }
}
