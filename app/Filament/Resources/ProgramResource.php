<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Filament\Resources\ProgramResource\RelationManagers;
use App\Models\Program;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-grid-add';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Program';
    protected static ?string $pluralLabel = 'Program';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('kegiatan_id')
//                    ->required(),
//                Forms\Components\TextInput::make('sub_kegiatan_id')
//                    ->required(),
//                Forms\Components\TextInput::make('rekening_id')
//                    ->required(),
                Forms\Components\TextInput::make('nama_program')
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
//                Tables\Columns\TextColumn::make('rekening_id'),
                Tables\Columns\TextColumn::make('nama_program')->searchable()->sortable(),
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
            'index' => Pages\ManagePrograms::route('/'),
        ];
    }
}
