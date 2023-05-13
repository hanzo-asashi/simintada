<?php

namespace App\Filament\Resources\PaketPengadaanResource\Pages;

use App\Filament\Resources\PaketPengadaanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaketPengadaan extends EditRecord
{
    protected static string $resource = PaketPengadaanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
