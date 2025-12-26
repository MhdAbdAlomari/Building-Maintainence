<?php

namespace App\Filament\Resources\TechnicianDetailResource\Pages;

use App\Filament\Resources\TechnicianDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTechnicianDetail extends EditRecord
{
    protected static string $resource = TechnicianDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
