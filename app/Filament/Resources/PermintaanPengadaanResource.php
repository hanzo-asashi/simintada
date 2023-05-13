<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermintaanPengadaanResource\Pages;
use App\Filament\Resources\PermintaanPengadaanResource\RelationManagers;
use App\Models\PermintaanPengadaan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermintaanPengadaanResource extends Resource
{
    protected static ?string $model = PermintaanPengadaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-add';

    protected static ?string $navigationLabel = 'Permintaan Pengadaan';
    protected static ?string $pluralLabel = 'Permintaan Pengadaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('instansi_id')
                    ->relationship('instansi', 'nama_instansi')
                    ->required(),
                Forms\Components\Select::make('sub_instansi_id')
                    ->relationship('sub_instansi', 'nama_sub_instansi')
                    ->required(),
                Forms\Components\Select::make('kegiatan_id')
                    ->relationship('kegiatan', 'nama_kegiatan')
                    ->required(),
                Forms\Components\Select::make('sub_kegiatan_id')
                    ->relationship('sub_kegiatan', 'nama_sub_kegiatan')
                    ->required(),
                Forms\Components\Select::make('rekening_id')
                    ->relationship('rekening', 'nama_rekening')
                    ->required(),
                Forms\Components\Select::make('program_id')
                    ->relationship('program', 'nama_program')
                    ->required(),
                Forms\Components\Select::make('produk_id')
                    ->relationship('produk', 'nama_produk')
                    ->required(),
                Forms\Components\Select::make('paket_pengadaan_id')
                    ->relationship('paketPengadaan', 'nama_paket_pengadaan')
                    ->required(),
                Forms\Components\RichEditor::make('spesifikasi_teknis_lainnya')
                    ->maxLength(65535),
                Forms\Components\DateTimePicker::make('waktu_pelaksanaan'),
                Forms\Components\DateTimePicker::make('waktu_barang_diterima'),
                Forms\Components\TextInput::make('lokasi_barang')
                    ->required()
                    ->maxLength(200),
                Forms\Components\TextInput::make('informasi_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('npwp_instansi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('kualifikasi_kinerja')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instansi.nama_instansi')
                    ->label('Instansi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sub_instansi.nama_sub_instansi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kegiatan.nama_kegiatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sub_kegiatan.nama_sub_kegiatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rekening.nama_rekening')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program.nama_program')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paketPengadaan.nama_paket_pengadaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('spesifikasi_teknis_lainnya'),
                Tables\Columns\TextColumn::make('waktu_pelaksanaan')
                    ->searchable()
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('waktu_barang_diterima')
                    ->searchable()
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('lokasi_barang'),
                Tables\Columns\TextColumn::make('informasi_lainnya'),
                Tables\Columns\TextColumn::make('npwp_instansi'),
                Tables\Columns\TextColumn::make('kualifikasi_kinerja'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPermintaanPengadaans::route('/'),
            'create' => Pages\CreatePermintaanPengadaan::route('/create'),
            'edit' => Pages\EditPermintaanPengadaan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
