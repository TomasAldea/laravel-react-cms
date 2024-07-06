<?php

namespace App\Filament\Resources\MenuWebResource\Pages;

use App\Filament\Resources\MenuWebResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenuWeb extends EditRecord
{
    protected static string $resource = MenuWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
