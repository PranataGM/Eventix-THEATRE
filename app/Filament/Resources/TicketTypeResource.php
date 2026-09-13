<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketTypeResource\Pages;
use App\Models\TicketType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketTypeResource extends Resource
{
    protected static ?string $model = TicketType::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Manajemen Acara';
    protected static ?string $navigationLabel = 'Jenis Tiket';
    protected static ?string $modelLabel = 'Jenis Tiket';
    protected static ?string $pluralModelLabel = 'Jenis Tiket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')
                    ->label('Acara')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tiket')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Misal: VIP, Regular'),
                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('quota')
                    ->label('Kuota')
                    ->required()
                    ->numeric()
                    ->rules([
                        fn (Forms\Get $get, ?\Illuminate\Database\Eloquent\Model $record) => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                            $eventId = $get('event_id');
                            if (!$eventId) return;
                            
                            $event = \App\Models\Event::find($eventId);
                            if (!$event) return;
                            
                            $existingQuota = \App\Models\TicketType::where('event_id', $eventId)
                                ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                                ->sum('quota');
                                
                            $remainingCapacity = $event->capacity - $existingQuota;
                            
                            if ($value > $remainingCapacity) {
                                $fail("Kuota melebihi kapasitas acara! (Tersisa: {$remainingCapacity} kursi dari total {$event->capacity})");
                            }
                        },
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.name')
                    ->label('Nama Acara')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Jenis Tiket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quota')
                    ->label('Kuota')
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
                        if ($record->registrations()->exists()) {
                            \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title('Gagal Menghapus')
                                ->body('Jenis tiket ini sudah memiliki tiket yang dibeli. Tidak dapat dihapus.')
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
                                if ($record->registrations()->exists()) {
                                    \Filament\Notifications\Notification::make()
                                        ->danger()
                                        ->title('Gagal Menghapus')
                                        ->body('Beberapa jenis tiket memiliki tiket yang telah dibeli. Proses dibatalkan secara keseluruhan.')
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
            'index' => Pages\ListTicketTypes::route('/'),
            'create' => Pages\CreateTicketType::route('/create'),
            'edit' => Pages\EditTicketType::route('/{record}/edit'),
        ];
    }
}
