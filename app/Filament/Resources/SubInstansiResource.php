<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubInstansiResource\Pages;
use App\Filament\Resources\SubInstansiResource\RelationManagers;
use App\Models\Instansi;
use App\Models\SubInstansi;
use App\Utilities\Helpers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubInstansiResource extends Resource
{
    protected static ?string $model = SubInstansi::class;

    protected static ?string $navigationIcon = 'heroicon-o-library';

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Sub Instansi';
    protected static ?string $pluralLabel = 'Sub Instansi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('instansi_id')
                    ->options(Instansi::pluck('nama_instansi', 'instansi_id'))
                    ->required(),
                Forms\Components\TextInput::make('nama_sub_instansi')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('short_sub_name')
                    ->nullable()
                    ->maxLength(30),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instansi.nama_instansi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kode_sub_instansi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('short_sub_name')->label('Alias')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama_sub_instansi')->sortable()->searchable(),
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
            'index' => Pages\ManageSubInstansis::route('/'),
        ];
    }
}
