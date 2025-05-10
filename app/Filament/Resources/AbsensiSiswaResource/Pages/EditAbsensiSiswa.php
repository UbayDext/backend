<?php

namespace App\Filament\Resources\AbsensiSiswaResource\Pages;

use App\Filament\Resources\AbsensiSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class EditAbsensiSiswa extends EditRecord
{
    protected static string $resource = AbsensiSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
     public function mount($record): void
    {
        try {
            parent::mount($record); 
        } catch (ModelNotFoundException $e) {
            abort(404, 'Data absensi siswa tidak ditemukan.');
        }
    }
}
