<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplateSuratResource\Pages;
use App\Filament\Resources\TemplateSuratResource\RelationManagers;
use App\Models\TemplateSurat;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TemplateSuratResource extends Resource
{
    protected static ?string $model = TemplateSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-template';

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Template Surat';
    protected static ?string $pluralLabel = 'Template Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('instansi_id')
                    ->required(),
                Forms\Components\TextInput::make('program_id')
                    ->required(),
                Forms\Components\TextInput::make('kegiatan_id')
                    ->required(),
                Forms\Components\TextInput::make('rekening_id')
                    ->required(),
                Forms\Components\TextInput::make('nama_surat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_surat')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('lampiran')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('perihal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ditujukan_ke')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tujuan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_penandatangan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nip_penandatangan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('tanggal_surat')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('instansi_id'),
//                Tables\Columns\TextColumn::make('program_id'),
//                Tables\Columns\TextColumn::make('kegiatan_id'),
//                Tables\Columns\TextColumn::make('rekening_id'),
                Tables\Columns\TextColumn::make('nama_surat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nomor_surat')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lampiran'),
                Tables\Columns\TextColumn::make('perihal')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ditujukan_ke'),
                Tables\Columns\TextColumn::make('tujuan'),
                Tables\Columns\TextColumn::make('nama_penandatangan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nip_penandatangan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tanggal_surat')
                    ->dateTime()->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTemplateSurats::route('/'),
        ];
    }
}
