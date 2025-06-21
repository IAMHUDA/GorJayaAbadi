<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function afterSave(): void
    {
        if ($this->record->status === 'sukses') {
            $this->record->pesanan?->update([
                'status' => 'dibayar',
            ]);
        }
    }
}
