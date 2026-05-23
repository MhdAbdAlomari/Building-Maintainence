<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalRequestResource\Pages;
use App\Models\WalletTransaction;
use App\Models\WithdrawalRequest;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalRequestResource extends Resource
{
    protected static ?string $model = WithdrawalRequest::class;

    protected static ?string $navigationLabel = 'Withdrawals';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationIcon  = 'heroicon-o-arrow-up-tray';
    protected static ?int $navigationSort     = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function table(Table $table): Table
    {
        $branchLabels      = WithdrawalRequest::branchLabels();
        $governorateLabels = WithdrawalRequest::governorateLabels();

        return $table
            ->striped()
            ->poll('30s')
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
                ->orderByDesc('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),

                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Technician')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                Tables\Columns\TextColumn::make('receiver_full_name')
                    ->label('Receiver')
                    ->searchable(),

                Tables\Columns\TextColumn::make('receiver_phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format((int) $state) . ' SYP')
                    ->color('success')
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('branch')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $branchLabels[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'tima'    => 'success',
                        'alharam' => 'info',
                        'alfouad' => 'purple',
                        'dovins'  => 'orange',
                        default   => 'gray',
                    }),

                Tables\Columns\TextColumn::make('governorate')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $governorateLabels[$state] ?? $state)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('branch')
                    ->options($branchLabels),
                Tables\Filters\SelectFilter::make('governorate')
                    ->options($governorateLabels),
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
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (WithdrawalRequest $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve withdrawal request')
                    ->modalDescription(fn (WithdrawalRequest $record) => sprintf(
                        "Amount: %s SYP\nBranch: %s\nGovernorate: %s\nReceiver: %s\nPhone: %s",
                        number_format((int) $record->amount),
                        WithdrawalRequest::branchLabels()[$record->branch] ?? $record->branch,
                        WithdrawalRequest::governorateLabels()[$record->governorate] ?? $record->governorate,
                        $record->receiver_full_name,
                        $record->receiver_phone,
                    ))
                    ->modalSubmitActionLabel('Approve')
                    ->action(function (WithdrawalRequest $record): void {
                        $wallet = $record->wallet;

                        if (!$wallet) {
                            Notification::make()->title('Wallet not found')->danger()->send();
                            return;
                        }

                        if ((int) $wallet->balance < (int) $record->amount) {
                            Notification::make()
                                ->title('Insufficient balance')
                                ->body('Wallet balance is less than the withdrawal amount.')
                                ->danger()
                                ->send();
                            return;
                        }

                        DB::transaction(function () use ($record, $wallet): void {
                            $wallet->decrement('balance', (int) $record->amount);

                            WalletTransaction::create([
                                'wallet_id'   => $wallet->id,
                                'amount'      => (int) $record->amount,
                                'type'        => 'debit',
                                'status'      => 'completed',
                                'description' => "Withdrawal request #{$record->id} approved",
                            ]);

                            $record->update([
                                'status'      => 'approved',
                                'reviewed_at' => now(),
                                'reviewed_by' => Auth::id(),
                            ]);
                        });

                        Notification::make()->title('Withdrawal approved')->success()->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (WithdrawalRequest $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection reason')
                            ->required()
                            ->minLength(3)
                            ->rows(3),
                    ])
                    ->action(function (array $data, WithdrawalRequest $record): void {
                        $record->update([
                            'status'           => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                            'reviewed_at'      => now(),
                            'reviewed_by'      => Auth::id(),
                        ]);

                        Notification::make()->title('Withdrawal rejected')->success()->send();
                    }),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        $branchLabels      = WithdrawalRequest::branchLabels();
        $governorateLabels = WithdrawalRequest::governorateLabels();

        return $infolist->schema([
            Infolists\Components\Section::make('Withdrawal Info')
                ->schema([
                    Infolists\Components\TextEntry::make('amount')
                        ->formatStateUsing(fn ($state) => number_format((int) $state) . ' SYP')
                        ->color('success')
                        ->weight(FontWeight::Bold),
                    Infolists\Components\TextEntry::make('branch')
                        ->badge()
                        ->formatStateUsing(fn (string $state) => $branchLabels[$state] ?? $state)
                        ->color(fn (string $state): string => match ($state) {
                            'tima'    => 'success',
                            'alharam' => 'info',
                            'alfouad' => 'purple',
                            'dovins'  => 'orange',
                            default   => 'gray',
                        }),
                    Infolists\Components\TextEntry::make('governorate')
                        ->badge()
                        ->formatStateUsing(fn (string $state) => $governorateLabels[$state] ?? $state)
                        ->color('gray'),
                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending'  => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default    => 'gray',
                        }),
                    Infolists\Components\TextEntry::make('note')
                        ->columnSpanFull()
                        ->placeholder('—'),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Receiver Info')
                ->schema([
                    Infolists\Components\TextEntry::make('receiver_full_name')->label('Full name'),
                    Infolists\Components\TextEntry::make('receiver_phone')->label('Phone'),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Review Info')
                ->schema([
                    Infolists\Components\TextEntry::make('reviewer.name')
                        ->label('Reviewed by')
                        ->placeholder('—'),
                    Infolists\Components\TextEntry::make('reviewed_at')
                        ->dateTime('M d, Y H:i')
                        ->placeholder('—'),
                    Infolists\Components\TextEntry::make('rejection_reason')
                        ->columnSpanFull()
                        ->visible(fn (WithdrawalRequest $record) => $record->status === 'rejected')
                        ->placeholder('—'),
                ])
                ->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawalRequests::route('/'),
            'view'  => Pages\ViewWithdrawalRequest::route('/{record}'),
        ];
    }
}
