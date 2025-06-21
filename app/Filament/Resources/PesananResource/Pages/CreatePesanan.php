<?php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePesanan extends CreateRecord
{
    protected static string $resource = PesananResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id(); // Isi otomatis user login
        return $data;
    }

    public function mount(): void
    {
        parent::mount();

        // Auto-isi lapangan_id jika URL punya ?lapangan_id=xx
        if (request()->has('lapangan_id')) {
            $this->form->fill([
                'lapangan_id' => request()->get('lapangan_id'),
            ]);
        }
    }
}
