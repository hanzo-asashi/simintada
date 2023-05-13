<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekeningResource\Pages;
use App\Filament\Resources\RekeningResource\RelationManagers;
use App\Models\Rekening;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekeningResource extends Resource
{
    protected static ?string $model = Rekening::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Rekening';
    protected static ?string $pluralLabel = 'Rekening';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('kegiatan_id')
//                    ->required(),
//                Forms\Components\TextInput::make('sub_kegiatan_id')
//                    ->required(),
                Forms\Components\TextInput::make('kode_rekening')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_rekening')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make('kegiatan_id'),
//                Tables\Columns\TextColumn::make('sub_kegiatan_id'),
                Tables\Columns\TextColumn::make('kode_rekening'),
                Tables\Columns\TextColumn::make('nama_rekening'),
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
            'index' => Pages\ManageRekenings::route('/'),
        ];
    }
}
