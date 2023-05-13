<?php

namespace App\Filament\Resources\PermintaanPengadaanResource\Pages;

use App\Filament\Resources\PermintaanPengadaanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermintaanPengadaans extends ListRecords
{
    protected static string $resource = PermintaanPengadaanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
