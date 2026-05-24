<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DebtSettlementResource\Pages;
use App\Models\Commission;
use App\Models\DebtSettlement;
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
use Illuminate\Support\Facades\Storage;

class DebtSettlementResource extends Resource
{
    protected static ?string $model = DebtSettlement::class;

    protected static ?string $navigationLabel = 'Debt Settlements';
    protected static ?string $modelLabel = 'Debt Settlement';
    protected static ?string $pluralModelLabel = 'Debt Settlements';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?int $navigationSort = 5;

    public static function canCreate(): bool
    {
        return false;
    }

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
        $branchLabels = DebtSettlement::branchLabels();

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

                Tables\Columns\ImageColumn::make('receipt_image')
                    ->label('Receipt')
                    ->getStateUsing(function (DebtSettlement $record) {
                        $image = (string) $record->receipt_image;
                        if ($image === '') {
                            return null;
                        }
                        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                            return $image;
                        }
                        return Storage::disk(config('filesystems.default'))->url(ltrim($image, '/'));
                    })
                    ->square()
                    ->size(60),

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
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from']  ?? null, fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (DebtSettlement $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve debt settlement')
                    ->modalDescription(fn (DebtSettlement $record) => sprintf(
                        "Technician: %s\nAmount: %s SYP\nBranch: %s",
                        $record->technician?->name ?? '-',
                        number_format((int) $record->amount),
                        DebtSettlement::branchLabels()[$record->branch] ?? $record->branch,
                    ))
                    ->modalSubmitActionLabel('Approve')
                    ->action(function (DebtSettlement $record): void {
                        DB::transaction(function () use ($record) {
                            $remaining = (int) $record->amount;

                            $pendingCommissions = Commission::where('technician_id', $record->technician_id)
                                ->where('status', 'pending_debt')
                                ->orderBy('created_at')
                                ->lockForUpdate()
                                ->get();

                            foreach ($pendingCommissions as $commission) {
                                if ($remaining <= 0) {
                                    break;
                                }

                                if ((int) $commission->commission_amount <= $remaining) {
                                    $remaining -= (int) $commission->commission_amount;
                                    $commission->update([
                                        'status'       => 'collected',
                                        'collected_at' => now(),
                                    ]);
                                }
                            }

                            $record->update([
                                'status'      => 'approved',
                                'reviewed_at' => now(),
                                'reviewed_by' => Auth::id(),
                            ]);
                        });

                        Notification::make()->title('Settlement approved')->success()->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (DebtSettlement $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection reason')
                            ->required()
                            ->minLength(3)
                            ->rows(3),
                    ])
                    ->action(function (array $data, DebtSettlement $record): void {
                        $record->update([
                            'status'           => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                            'reviewed_at'      => now(),
                            'reviewed_by'      => Auth::id(),
                        ]);

                        Notification::make()->title('Settlement rejected')->success()->send();
                    }),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        $branchLabels = DebtSettlement::branchLabels();

        return $infolist->schema([
            Infolists\Components\Section::make('Settlement Info')
                ->schema([
                    Infolists\Components\TextEntry::make('technician.name')->label('Technician'),
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

            Infolists\Components\Section::make('Receipt')
                ->schema([
                    Infolists\Components\ImageEntry::make('receipt_image')
                        ->disk(config('filesystems.default'))
                        ->height(400)
                        ->columnSpanFull(),
                ]),

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
                        ->visible(fn (DebtSettlement $record) => $record->status === 'rejected')
                        ->placeholder('—'),
                ])
                ->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDebtSettlements::route('/'),
            'view'  => Pages\ViewDebtSettlement::route('/{record}'),
        ];
    }
}
