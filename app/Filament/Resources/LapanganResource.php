<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LapanganResource\Pages;
use App\Filament\Resources\LapanganResource\RelationManagers;
use App\Models\Lapangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class LapanganResource extends Resource
{
    protected static ?string $model = Lapangan::class;
    protected static ?string $navigationLabel = 'Data Lapangan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->required()
                ->label('Nama Lapangan'),
            Select::make('jenis')
                ->options([
                    'badminton' => 'Badminton',
                    'futsal' => 'Futsal',
                ])
                ->required(),
            TextInput::make('harga')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Harga per Jam'),
            Select::make('status')
                ->options([
                    true => 'Aktif',
                    false => 'Tidak Aktif',
                ])
                ->required()
                ->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->sortable(),
            TextColumn::make('nama')->searchable(),
            TextColumn::make('jenis')->badge(),
            TextColumn::make('harga')->label('Harga')->money('IDR', true),
            TextColumn::make('status')->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Nonaktif'),
            TextColumn::make('created_at')->dateTime()->label('Dibuat'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLapangans::route('/'),
            'create' => Pages\CreateLapangan::route('/create'),
            'edit' => Pages\EditLapangan::route('/{record}/edit'),
        ];
    }
}
