<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelajaranResource\Pages;
use App\Filament\Resources\PelajaranResource\RelationManagers;
use App\Models\Pelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DateTimePicker;

class PelajaranResource extends Resource
{
    protected static ?string $model = Pelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(191),
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('waktu mulai')
                    ->required()
                    ->displayFormat('Y-m-d H:i:s')
                    ->seconds(),
                Forms\Components\DateTimePicker::make('end_time')
                    ->label('waktu selesai')
                    ->required()
                    ->displayFormat('Y-m-d H:i:s')
                    ->seconds(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('waktu  mulai')
                    ->dateTime('Y-m-d H:i:s'),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('waktu selesai')
                    ->dateTime('Y-m-d H:i:s'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPelajarans::route('/'),
            'create' => Pages\CreatePelajaran::route('/create'),
            'edit' => Pages\EditPelajaran::route('/{record}/edit'),
        ];
    }
}
