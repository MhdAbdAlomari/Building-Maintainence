<?php

namespace App\Filament\Resources\WalletResource\Pages;

use App\Filament\Resources\WalletResource;
use App\Models\WalletTransaction;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewWallet extends ViewRecord
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('adjust')
                ->label('Manual Adjustment')
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('type')
                        ->options(['credit' => 'Credit (add)', 'debit' => 'Debit (subtract)'])
                        ->required(),
                    Forms\Components\TextInput::make('amount')->numeric()->minValue(1)->required(),
                    Forms\Components\TextInput::make('description')->label('Reason')->required()->maxLength(255),
                ])
                ->action(function (array $data): void {
                    DB::transaction(function () use ($data) {
                        $amount = (int) $data['amount'];
                        $newBalance = $data['type'] === 'credit'
                            ? $this->record->balance + $amount
                            : $this->record->balance - $amount;

                        if ($newBalance < 0) {
                            Notification::make()->title('Insufficient balance')->danger()->send();
                            return;
                        }

                        $this->record->update(['balance' => $newBalance]);

                        WalletTransaction::create([
                            'wallet_id'   => $this->record->id,
                            'amount'      => $amount,
                            'type'        => $data['type'],
                            'status'      => 'completed',
                            'description' => $data['description'],
                        ]);
                    });

                    $this->refreshFormData(['balance']);
                    Notification::make()->title('Wallet adjusted')->success()->send();
                }),
            Actions\EditAction::make(),
        ];
    }
}
