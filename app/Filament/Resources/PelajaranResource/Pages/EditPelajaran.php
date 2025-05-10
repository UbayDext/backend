<?php

namespace App\Filament\Resources\PelajaranResource\Pages;

use App\Filament\Resources\PelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class EditPelajaran extends EditRecord
{
    protected static string $resource = PelajaranResource::class;

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
