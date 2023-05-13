<?php

namespace App\Filament\Resources\PermintaanPengadaanResource\Pages;

use App\Filament\Resources\PermintaanPengadaanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermintaanPengadaan extends EditRecord
{
    protected static string $resource = PermintaanPengadaanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
