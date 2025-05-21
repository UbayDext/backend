<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiSiswaResource\Pages;
use App\Filament\Resources\AbsensiSiswaResource\RelationManagers;
use App\Models\AbsensiSiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class AbsensiSiswaResource extends Resource
{
    protected static ?string $model = AbsensiSiswa::class;

    protected static ?string $navigationIcon = 'heroicon-s-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name') // asumsinya relasi sudah ada
                    ->searchable(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\Select::make('pelajaran_id')
                    ->relationship('pelajaran', 'nama') // Pastikan relasi `pelajaran()` ada di model
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TimePicker::make('check_in_time')
                    ->label('mulai jam pelajaran')
                    ->required()
                    ->seconds(),
                Forms\Components\TimePicker::make('check_out_time')
                    ->label('selesai jam pelajaran')
                    ->required()
                    ->seconds(),
                Forms\Components\Select::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha' => 'Alpha',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('name')->label('Nama Absen'),
                Tables\Columns\TextColumn::make('pelajaran.nama')->label('Pelajaran'),
                Tables\Columns\TextColumn::make('classroom.name')->label('Kelas'),
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->date(),
                Tables\Columns\TextColumn::make('check_in_time')->label('Masuk'),
                Tables\Columns\TextColumn::make('check_out_time')->label('Keluar'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ])

            ->filters([
                SelectFilter::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->searchable(),

                SelectFilter::make('pelajaran_id')
                    ->label('Pelajaran')
                    ->relationship('pelajaran', 'nama')
                    ->searchable(),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAbsensiSiswas::route('/'),
            'create' => Pages\CreateAbsensiSiswa::route('/create'),
            'edit' => Pages\EditAbsensiSiswa::route('/{record}/edit'),
        ];
    }
}
