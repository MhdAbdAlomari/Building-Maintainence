<?php

namespace App\Filament\Resources\TechnicianResource\Pages;

use App\Filament\Resources\TechnicianResource;
use App\Models\TechnicianDetail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTechnician extends EditRecord
{
    protected static string $resource = TechnicianResource::class;

    protected array $detailData = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $detail = $this->record->technicianDetail;
        $data['technicianDetail'] = $detail ? [
            'service_id'          => $detail->service_id,
            'years_of_experience' => $detail->years_of_experience,
            'max_distance_km'     => $detail->max_distance_km,
            'skills_description'  => $detail->skills_description,
        ] : [];
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->detailData = $data['technicianDetail'] ?? [];
        unset($data['technicianDetail']);
        return $data;
    }

    protected function afterSave(): void
    {
        if (! empty($this->detailData) && ! empty($this->detailData['service_id'])) {
            TechnicianDetail::updateOrCreate(
                ['user_id' => $this->record->id],
                $this->detailData,
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
