<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Manajemen Acara';
    protected static ?string $navigationLabel = 'Daftar Acara';
    protected static ?string $modelLabel = 'Acara';
    protected static ?string $pluralModelLabel = 'Acara';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('organizer', 'name')
                    ->label('Penyelenggara')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Acara')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('event_date')
                    ->label('Tanggal Acara')
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label('Lokasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('capacity')
                    ->label('Kapasitas')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Acara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('organizer.name')
                    ->label('Penyelenggara')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Tables\Actions\DeleteAction $action, $record) {
                        if ($record->ticketTypes()->whereHas('registrations')->exists()) {
                            \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title('Gagal Menghapus')
                                ->body('Acara ini sudah memiliki tiket yang dibeli. Tidak dapat dihapus untuk mencegah hilangnya data tiket.')
                                ->send();
                            
                            $action->halt();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Tables\Actions\DeleteBulkAction $action, \Illuminate\Database\Eloquent\Collection $records) {
                            foreach ($records as $record) {
                                if ($record->ticketTypes()->whereHas('registrations')->exists()) {
                                    \Filament\Notifications\Notification::make()
                                        ->danger()
                                        ->title('Gagal Menghapus')
                                        ->body('Beberapa acara memiliki tiket yang telah dibeli. Proses dibatalkan secara keseluruhan.')
                                        ->send();
                                    $action->halt();
                                }
                            }
                        }),
                ]),
            ])
            ->paginated(false);
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
