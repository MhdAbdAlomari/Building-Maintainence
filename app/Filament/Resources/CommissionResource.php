<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommissionResource\Pages;
use App\Models\Commission;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static ?string $navigationLabel = 'Commissions';
    protected static ?string $modelLabel = 'Commission';
    protected static ?string $pluralModelLabel = 'Commissions';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->poll('30s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),

                Tables\Columns\TextColumn::make('request_id')
                    ->label('Request')
                    ->sortable(),

                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Technician')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                Tables\Columns\TextColumn::make('request_amount')
                    ->label('Request Amount')
                    ->formatStateUsing(fn ($state) => number_format((int) $state) . ' SYP')
                    ->sortable(),

                Tables\Columns\TextColumn::make('commission_rate')
                    ->label('Rate')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('commission_amount')
                    ->label('Commission')
                    ->formatStateUsing(fn ($state) => number_format((int) $state) . ' SYP')
                    ->color('success')
                    ->weight(FontWeight::Bold)
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->icon(fn (string $state): string => $state === 'cash'
                        ? 'heroicon-m-banknotes'
                        : 'heroicon-m-credit-card')
                    ->color(fn (string $state): string => $state === 'cash' ? 'warning' : 'info'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'collected'    => 'Collected',
                        'pending_debt' => 'Pending debt',
                        default        => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'collected'    => 'success',
                        'pending_debt' => 'danger',
                        default        => 'gray',
                    }),

                Tables\Columns\TextColumn::make('collected_at')
                    ->dateTime('M d, Y H:i')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'collected'    => 'Collected',
                        'pending_debt' => 'Pending debt',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(['cash' => 'Cash', 'stripe' => 'Stripe']),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommissions::route('/'),
        ];
    }
}
