<?php

namespace App\Filament\Pages;

use App\Models\AppSetting;
use App\Models\WithdrawalRequest;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AppSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'App Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'App Settings';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.app-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'commission_rate'   => AppSetting::getCommissionRate(),
            'debt_ceiling'      => AppSetting::getDebtCeiling(),
            'owner_name'        => AppSetting::get('owner_name'),
            'owner_phone'       => AppSetting::get('owner_phone'),
            'owner_governorate' => AppSetting::get('owner_governorate', 'damascus'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Commission')
                    ->description('Commission rate is captured as a snapshot at the time of each payment.')
                    ->schema([
                        TextInput::make('commission_rate')
                            ->label('Commission Rate (%)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50)
                            ->required()
                            ->suffix('%'),
                    ]),
                Section::make('Debt')
                    ->description('Maximum unpaid commission allowed before a technician is blocked from new requests.')
                    ->schema([
                        TextInput::make('debt_ceiling')
                            ->label('Debt Ceiling (SYP)')
                            ->numeric()
                            ->minValue(1000)
                            ->required()
                            ->suffix('SYP'),
                    ]),
                Section::make('Owner Transfer Info')
                    ->description('Shown to technicians when they need to transfer settlement payments.')
                    ->schema([
                        TextInput::make('owner_name')
                            ->label('Owner Full Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('owner_phone')
                            ->label('Owner Phone')
                            ->tel()
                            ->required()
                            ->maxLength(50),
                        Select::make('owner_governorate')
                            ->label('Owner Governorate')
                            ->options(WithdrawalRequest::governorateLabels())
                            ->required()
                            ->native(false),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        AppSetting::set('commission_rate', (int) $data['commission_rate']);
        AppSetting::set('debt_ceiling', (int) $data['debt_ceiling']);
        AppSetting::set('owner_name', $data['owner_name']);
        AppSetting::set('owner_phone', $data['owner_phone']);
        AppSetting::set('owner_governorate', $data['owner_governorate']);

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
