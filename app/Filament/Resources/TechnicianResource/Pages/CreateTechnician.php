<?php

namespace App\Filament\Resources\TechnicianResource\Pages;

use App\Filament\Resources\TechnicianResource;
use App\Models\TechnicianDetail;
use App\Models\Wallet;
use Filament\Resources\Pages\CreateRecord;

class CreateTechnician extends CreateRecord
{
    protected static string $resource = TechnicianResource::class;

    protected array $detailData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'technician';
        $this->detailData = $data['technicianDetail'] ?? [];
        unset($data['technicianDetail']);
        return $data;
    }

    protected function afterCreate(): void
    {
        if (! empty($this->detailData) && ! empty($this->detailData['service_id'])) {
            TechnicianDetail::updateOrCreate(
                ['user_id' => $this->record->id],
                $this->detailData,
            );
        }

        Wallet::firstOrCreate(
            ['technician_id' => $this->record->id],
            ['balance' => 0, 'currency' => 'SYP'],
        );
    }
}
