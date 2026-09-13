<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Pendaftaran';
    protected static ?string $modelLabel = 'Pendaftaran';
    protected static ?string $pluralModelLabel = 'Pendaftaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Peserta')
                    ->required(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')
                    ->label('Acara')
                    ->required(),
                Forms\Components\Select::make('ticket_type_id')
                    ->relationship('ticketType', 'name')
                    ->label('Jenis Tiket')
                    ->required(),
                Forms\Components\TextInput::make('ticket_code')
                    ->label('Kode Tiket')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Jumlah Tiket')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->rules([
                        fn (Forms\Get $get, ?\Illuminate\Database\Eloquent\Model $record) => function (string $attribute, $value, \Closure $fail) use ($get, $record) {
                            $ticketTypeId = $get('ticket_type_id');
                            if (!$ticketTypeId) return;
                            
                            $ticketType = \App\Models\TicketType::find($ticketTypeId);
                            if (!$ticketType) return;
                            
                            $remaining = $ticketType->remaining_quota;
                            
                            if ($record && $record->ticket_type_id == $ticketTypeId) {
                                // Ignore this record's own quantity if we are updating it
                                if (in_array($record->status, ['confirmed', 'pending'])) {
                                    $remaining += $record->quantity;
                                }
                            }
                            
                            if ($value > $remaining) {
                                $fail("Jumlah tiket melebihi sisa kuota yang tersedia ({$remaining} tiket tersisa).");
                            }
                        },
                    ]),
                Forms\Components\Toggle::make('is_checked_in')
                    ->label('Telah Hadir (Check In)'),
                Forms\Components\DateTimePicker::make('checked_in_at')
                    ->label('Waktu Kehadiran'),
                
                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Metode'),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Lunas (Paid)',
                                'failed' => 'Gagal',
                            ]),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Peserta')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.name')
                    ->label('Acara')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Pesanan #')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('Kode Tiket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jml')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Pembayaran'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Tiket')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_checked_in')
                    ->label('Hadir')
                    ->boolean(),
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
            ])
            ->paginated(false)
            ->groups([
                \Filament\Tables\Grouping\Group::make('event.event_date')
                    ->label('Hari Acara')
                    ->date(),
                \Filament\Tables\Grouping\Group::make('event.category.name')
                    ->label('Kategori'),
            ])
            ->defaultGroup('event.event_date');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('payment_status', 'paid')
            ->orWhere('status', 'confirmed');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
