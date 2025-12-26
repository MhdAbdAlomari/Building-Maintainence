<?php

namespace App\Filament\Resources\TechnicianDetailResource\Pages;

use App\Filament\Resources\TechnicianDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTechnicianDetails extends ListRecords
{
    protected static string $resource = TechnicianDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
