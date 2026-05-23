<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletResource\Pages;
use App\Filament\Resources\WalletResource\RelationManagers;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationLabel = 'Wallets';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('technician_id')
                ->relationship('technician', 'name', fn ($q) => $q->where('role', 'technician'))
                ->required()->searchable()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('balance')->numeric()->required()->default(0),
            Forms\Components\TextInput::make('currency')->default('SYP')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('technician.name')->label('Technician')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('balance')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('currency'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('M d, Y H:i')->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('adjust')
                    ->label('Adjust')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('type')
                            ->options(['credit' => 'Credit (add)', 'debit' => 'Debit (subtract)'])
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()->minValue(1)->required(),
                        Forms\Components\TextInput::make('description')
                            ->label('Reason')->required()->maxLength(255),
                    ])
                    ->action(function (array $data, Wallet $record): void {
                        DB::transaction(function () use ($data, $record) {
                            $amount = (int) $data['amount'];
                            $newBalance = $data['type'] === 'credit'
                                ? $record->balance + $amount
                                : $record->balance - $amount;

                            if ($newBalance < 0) {
                                Notification::make()
                                    ->title('Insufficient balance')
                                    ->danger()->send();
                                return;
                            }

                            $record->update(['balance' => $newBalance]);

                            WalletTransaction::create([
                                'wallet_id'   => $record->id,
                                'amount'      => $amount,
                                'type'        => $data['type'],
                                'status'      => 'completed',
                                'description' => $data['description'],
                            ]);
                        });

                        Notification::make()->title('Wallet adjusted')->success()->send();
                    }),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Wallet')->schema([
                Infolists\Components\TextEntry::make('technician.name')->label('Technician'),
                Infolists\Components\TextEntry::make('balance')->numeric()->suffix(fn ($record) => ' ' . $record->currency),
                Infolists\Components\TextEntry::make('currency'),
                Infolists\Components\TextEntry::make('updated_at')->dateTime(),
            ])->columns(2),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListWallets::route('/'),
            'create' => Pages\CreateWallet::route('/create'),
            'view'   => Pages\ViewWallet::route('/{record}'),
            'edit'   => Pages\EditWallet::route('/{record}/edit'),
        ];
    }
}
