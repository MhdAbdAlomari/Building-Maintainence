<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationLabel = 'Banners';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image')
                ->disk(config('filesystems.default'))
                ->directory('banners')
                ->visibility('public')
                ->image()
                ->imageEditor()
                ->required()
                ->shouldFetchFileInformation(false)
                ->afterStateHydrated(function (BaseFileUpload $component, $state): void {
                    if (blank($state)) {
                        $component->state([]);
                        return;
                    }

                    $path = (string) $state;

                    if (preg_match('#/storage/(.+)$#', $path, $m)) {
                        $path = $m[1];
                    }

                    $component->state([(string) Str::uuid() => $path]);
                }),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->required(),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->poll('30s')
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->getStateUsing(function ($record) {
                        $image = (string) $record->image;
                        if ($image === '') {
                            return null;
                        }
                        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                            return $image;
                        }
                        return Storage::disk(config('filesystems.default'))->url(ltrim($image, '/'));
                    })
                    ->width(100)
                    ->height(60)
                    ->extraImgAttributes(['class' => 'rounded-lg object-cover']),
                Tables\Columns\TextColumn::make('sort_order')->sortable()->alignCenter(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit'   => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
