<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;



class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pesanan_id')
                    ->label('Pesanan')
                    ->relationship(
                        name: 'pesanan',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn($query) => $query->where('status', 'pending')
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->user->name} - {$record->lapangan->nama} - {$record->tanggal_booking}")
                    ->searchable()
                    ->required(),

                Select::make('metode')
                    ->label('Metode Pembayaran')
                    ->options([
                        'transfer' => 'Transfer Bank',
                        'tunai' => 'Tunai',
                        'qris' => 'QRIS',
                    ])
                    ->reactive()
                    ->required(),

                Forms\Components\Placeholder::make('qris_dummy')
                    ->label('QRIS Pembayaran')
                    ->content('Silakan scan QR berikut untuk melakukan pembayaran.')
                    ->visible(fn(callable $get) => $get('metode') === 'qris'),

                Forms\Components\Placeholder::make('gambar_qris')
                    ->label('Kode QRIS')
                    ->content('<img src="https://via.placeholder.com/200x200.png?text=QRIS+Dummy" class="mx-auto" width="200" />')
                    ->visible(fn(callable $get) => $get('metode') === 'qris')
                    ->extraAttributes(['class' => 'text-center']),

                Forms\Components\Placeholder::make('rekening_dummy')
                    ->label('Info Transfer Bank')
                    ->content('Bank BNI - 1234567890 a.n. GOR Elite')
                    ->visible(fn(callable $get) => $get('metode') === 'transfer'),

                TextInput::make('nominal_tunai')
                    ->label('Nominal Tunai')
                    ->numeric()
                    ->reactive()
                    ->visible(fn(callable $get) => $get('metode') === 'tunai')
                    ->afterStateUpdated(
                        fn($state, callable $set, callable $get) =>
                        $get('metode') === 'tunai' ? $set('total_bayar', $state) : null
                    ),

                TextInput::make('total_bayar')
                    ->label('Total Bayar')
                    ->numeric()
                    ->required()
                    ->visible(fn(callable $get) => $get('metode') !== 'tunai' || filled($get('nominal_tunai'))),

                Select::make('status')
                    ->label('Status Pembayaran')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'sukses' => 'Sukses',
                        'gagal' => 'Gagal',
                    ])
                    ->default('menunggu')
                    ->required(),

                DateTimePicker::make('tanggal_bayar')
                    ->label('Tanggal Bayar')
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pesanan.id')->label('ID Pesanan'),
                TextColumn::make('metode')->label('Metode'),
                TextColumn::make('total_bayar')->money('IDR', locale: 'id'),
                TextColumn::make('status')->badge()->colors([
                    'primary' => 'menunggu',
                    'success' => 'sukses',
                    'danger' => 'gagal',
                ]),
                TextColumn::make('tanggal_bayar')->dateTime('d/m/Y H:i')->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}
