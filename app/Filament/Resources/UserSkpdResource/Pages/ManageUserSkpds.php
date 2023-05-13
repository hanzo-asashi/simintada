<?php

namespace App\Filament\Resources\UserSkpdResource\Pages;

use App\Filament\Resources\UserSkpdResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUserSkpds extends ManageRecords
{
    protected static string $resource = UserSkpdResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
