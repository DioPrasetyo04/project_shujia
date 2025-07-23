<?php

namespace App\Filament\Resources\HomeServicesResource\Pages;

use App\Filament\Resources\HomeServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeServices extends EditRecord
{
    protected static string $resource = HomeServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
