<?php

namespace App\Filament\Resources\HomeServicesResource\Pages;

use App\Filament\Resources\HomeServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeServices extends ListRecords
{
    protected static string $resource = HomeServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
