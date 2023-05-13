<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserSkpdResource\Pages;
use App\Filament\Resources\UserSkpdResource\RelationManagers;
use App\Models\UserSkpd;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserSkpdResource extends Resource
{
    protected static ?string $model = UserSkpd::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 9;

    protected static ?string $navigationLabel = 'Pengguna Instansi';
    protected static ?string $pluralLabel = 'Pengguna Instansi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('skpd_id')
                    ->relationship('instansi', 'nama_instansi')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('instansi.nama_instansi'),
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
            'index' => Pages\ManageUserSkpds::route('/'),
        ];
    }
}
