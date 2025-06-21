<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;


use Filament\Tables\Columns\TextColumn;




class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pesanan Lapangan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('Nama Pemesan')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Select::make('lapangan_id')
                ->label('Lapangan')
                ->relationship('lapangan', 'nama')
                ->searchable()
                ->required(),

            DatePicker::make('tanggal_booking')
                ->label('Tanggal Booking')
                ->required(),

            TimePicker::make('jam_mulai')
                ->label('Jam Mulai')
                ->required(),

            TimePicker::make('jam_selesai')
                ->label('Jam Selesai')
                ->required()
                ->after('jam_mulai')
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    $lapanganId = $get('lapangan_id');
                    $tanggal = $get('tanggal_booking');
                    $jamMulai = $get('jam_mulai');
                    $jamSelesai = $state;

                    if (!$lapanganId || !$tanggal || !$jamMulai || !$jamSelesai) {
                        return;
                    }

                    $conflict = \App\Models\Pesanan::where('lapangan_id', $lapanganId)
                        ->where('tanggal_booking', $tanggal)
                        ->where(function ($query) use ($jamMulai, $jamSelesai) {
                            $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                                ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                                ->orWhere(function ($query) use ($jamMulai, $jamSelesai) {
                                    $query->where('jam_mulai', '<=', $jamMulai)
                                        ->where('jam_selesai', '>=', $jamSelesai);
                                });
                        })
                        ->when(request()->route('record'), function ($query) {
                            $query->where('id', '!=', request()->route('record'));
                        })
                        ->exists();

                    if ($conflict) {
                        // Kosongkan nilai agar memicu error di bawah
                        $set('jam_selesai', null);
                        Notification::make()
                            ->title('Gagal')
                            ->body('Waktu booking bentrok dengan pesanan lain!')
                            ->danger()
                            ->send();
                    }
                }),





            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'dibayar' => 'Dibayar',
                    'selesai' => 'Selesai',
                ])
                ->default('pending')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
{
    return $table->columns([
        TextColumn::make('user.name')->label('Pemesan')->searchable(),
        TextColumn::make('lapangan.nama')->label('Lapangan')->searchable(),
        TextColumn::make('tanggal_booking')->label('Tanggal')->date(),
        TextColumn::make('jam_mulai'),
        TextColumn::make('jam_selesai'),
        TextColumn::make('lapangan.harga')
            ->label('Harga per Jam')
            ->money('IDR', true)
            ->sortable(),
        TextColumn::make('status')->badge(),
    ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
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
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
