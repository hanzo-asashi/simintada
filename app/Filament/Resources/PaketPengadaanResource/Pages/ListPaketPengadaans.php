<?php

declare(strict_types=1);

namespace App\Filament\Resources\PaketPengadaanResource\Pages;

use App\Filament\Resources\PaketPengadaanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class ListPaketPengadaans extends ListRecords
{
    protected static string $resource = PaketPengadaanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->fastPaginate($this->getTableRecordsPerPage());
    }

}
