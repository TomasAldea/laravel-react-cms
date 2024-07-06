<?php

namespace App\Filament\Resources\MenuWebResource\Pages;

use App\Filament\Resources\MenuWebResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenuWebs extends ListRecords
{
    protected static string $resource = MenuWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
