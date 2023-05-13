<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\PaketPengadaanResource\Pages;
use App\Filament\Resources\PaketPengadaanResource\RelationManagers;
use App\Models\Kegiatan;
use App\Models\PaketPengadaan;
use App\Models\Program;
use App\Models\Rekening;
use App\Models\SubKegiatan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaketPengadaanResource extends Resource
{
    protected static ?string $model = PaketPengadaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-add';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Paket Pengadaan';
    protected static ?string $pluralLabel = 'Paket Pengadaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('nama_paket_pengadaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_rup')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('pagu_hps'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_paket_pengadaan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kode_rup'),
                Tables\Columns\TextColumn::make('pagu')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('hps')->searchable()->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->appendHeaderActions([
                FilamentExportHeaderAction::make('export')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
//                FilamentExportBulkAction::make('export')
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaketPengadaans::route('/'),
            'create' => Pages\CreatePaketPengadaan::route('/create'),
            'edit' => Pages\EditPaketPengadaan::route('/{record}/edit'),
        ];
    }
}
