<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePembayaran extends CreateRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function afterCreate(): void
{
    $pembayaran = $this->record;

    if ($pembayaran->status === 'sukses' && $pembayaran->pesanan) {
        $pembayaran->pesanan->update(['status' => 'dibayar']);
    }
}
}
