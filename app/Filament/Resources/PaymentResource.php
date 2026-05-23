<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationLabel = 'Payments';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('request_id')
                ->relationship('workRequest', 'title')
                ->required()->searchable()->preload(),
            Forms\Components\Select::make('tenant_id')
                ->relationship('tenant', 'name', fn (Builder $query) => $query->where('role', 'tenant'))
                ->required()->searchable()->preload(),
            Forms\Components\TextInput::make('amount_usd_cents')->label('Amount (SYP)')->numeric()->required(),
            Forms\Components\TextInput::make('currency')->default('SYP')->required(),
            Forms\Components\Select::make('payment_method')
                ->options(['stripe' => 'Stripe', 'cash' => 'Cash'])
                ->required()->default('cash'),
            Forms\Components\Select::make('status')
                ->options([
                    'pending'  => 'Pending',
                    'paid'     => 'Paid',
                    'failed'   => 'Failed',
                    'canceled' => 'Canceled',
                ])
                ->required()->default('pending'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->poll('30s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('request_id')->label('Request')->sortable(),
                Tables\Columns\TextColumn::make('tenant.name')->label('Tenant')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('workRequest.technician.name')->label('Technician')->placeholder('—'),
                Tables\Columns\TextColumn::make('amount_usd_cents')
                    ->label('Amount (SYP)')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->icon(fn (string $state): string => $state === 'cash'
                        ? 'heroicon-m-banknotes'
                        : 'heroicon-m-credit-card')
                    ->color(fn (string $state): string => $state === 'cash' ? 'success' : 'info'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->icon(fn (string $state): string => match ($state) {
                        'paid'     => 'heroicon-m-check-circle',
                        'pending'  => 'heroicon-m-clock',
                        'failed'   => 'heroicon-m-x-circle',
                        'canceled' => 'heroicon-m-no-symbol',
                        default    => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid'     => 'success',
                        'pending'  => 'warning',
                        'failed'   => 'danger',
                        'canceled' => 'gray',
                        default    => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime('M d, Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(['stripe' => 'Stripe', 'cash' => 'Cash']),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'paid'     => 'Paid',
                        'failed'   => 'Failed',
                        'canceled' => 'Canceled',
                    ]),
                Tables\Filters\Filter::make('created_between')
                    ->label('Created Date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from']  ?? null, fn (Builder $q, $v) => $q->whereDate('created_at', '>=', $v))
                            ->when($data['until'] ?? null, fn (Builder $q, $v) => $q->whereDate('created_at', '<=', $v));
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportCsv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (): StreamedResponse {
                        $filename = 'payments_' . now()->format('Y_m_d_His') . '.csv';

                        return response()->streamDownload(function () {
                            $out = fopen('php://output', 'w');
                            fputcsv($out, ['ID', 'Request', 'Tenant', 'Technician', 'Amount (SYP)', 'Currency', 'Method', 'Status', 'Created At']);

                            Payment::query()
                                ->with(['tenant', 'workRequest.technician'])
                                ->orderByDesc('created_at')
                                ->chunk(500, function ($chunk) use ($out) {
                                    foreach ($chunk as $p) {
                                        fputcsv($out, [
                                            $p->id,
                                            $p->request_id,
                                            $p->tenant?->name,
                                            $p->workRequest?->technician?->name,
                                            $p->amount_usd_cents,
                                            $p->currency,
                                            $p->payment_method,
                                            $p->status,
                                            optional($p->created_at)->toDateTimeString(),
                                        ]);
                                    }
                                });

                            fclose($out);
                        }, $filename, ['Content-Type' => 'text/csv']);
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit'   => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Pages\PaymentStats::class,
        ];
    }
}
