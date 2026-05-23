<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'createdRequests';
    protected static ?string $title = 'Requests';
    protected static ?string $recordTitleAttribute = 'title';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('title')->limit(28)->searchable(),
                Tables\Columns\TextColumn::make('service.name')->label('Service')->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'                 => 'warning',
                        'estimate_price'          => 'info',
                        'confirmed'               => 'primary',
                        'processing'              => 'info',
                        'awaiting_final_approval' => 'warning',
                        'completed'               => 'success',
                        'rejected'                => 'danger',
                        'cancelled'               => 'gray',
                        default                   => 'gray',
                    }),
                Tables\Columns\TextColumn::make('final_price_syp')->label('Final')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_paid')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('Open')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn ($record) => \App\Filament\Resources\RequestResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
