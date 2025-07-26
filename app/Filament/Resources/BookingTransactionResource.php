<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HomeService;
use Filament\Resources\Resource;
use App\Models\BookingTransaction;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-s-credit-card';

    // group for navigation

    protected static ?string $navigationGroup = 'Transactions';

    public static function updateTotals(Get $get, Set $set)
    {
        // collect data karena bentuknya array data ada home_service_id dan price kemudian di filter yang idnya home service_id tidak sama dengan null
        $selectedHomeService = collect($get('transactionDetails'))->filter(function ($item) {
            // mencari dan mengembalikan data yang memiliki home_service_id
            return !empty($item['home_service_id']);
        });

        // mengambil harga dari HomeService berdasarkan home_service_id yang dipilih
        // pluck home_service_id berfungsi untuk mengambil harga dari HomeService berdasarkan home_service_id yang dipilih
        $prices = HomeService::find($selectedHomeService->pluck('home_service_id'))->pluck('price', 'id');

        // menghitung subtotal seluruh product yang dipilih user
        // menggunakan reduce untuk mengkaumulasi harga jadi dari bentuk array menjadi satu nilai
        $subTotal = $selectedHomeService->reduce(function ($subtotal, $item) use ($prices) {
            // mengakumulasi harga berdasarkan home_service_id
            // nyri pricenya lalu di get yang sesuai dengan home_service_id
            return $subtotal + ($prices->get($item['home_service_id']) * 1);
        }, 0);

        $total_tax_amount = round($subTotal * 0.11);
        $total_amount = round($subTotal + $total_tax_amount);

        $set('sub_total', $subTotal);
        $set('total_tax_amount', $total_tax_amount);
        $set('total_amount', $total_amount);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product and Price')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Add your product item and its price')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Repeater::make('transactionDetails')
                                        ->relationship('transactionDetails')
                                        ->schema([
                                            Select::make('home_service_id')
                                                // relasi ke table data  HomeService dan mengambil namanya aja dari table HomeService 
                                                // hasilnya nama tapi data yang kesimpan adalah id
                                                ->relationship('homeService', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->label('Select Product')
                                                ->required()
                                                // untuk kalkulasi price dengan live dan afterStateUpdated
                                                // setelah user memilih product maka akan mengupdate harga di field price
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    // find model atau table home service yang dipilih oleh user
                                                    $home_service = HomeService::find($state);
                                                    // set pricenya berdasarkan home service yang dipilih dan melakukan format number
                                                    $set('price', $home_service->price);
                                                }),
                                            TextInput::make('price')
                                                ->label('Price')
                                                ->helperText('Price of the product automatically filled')
                                                ->required()
                                                ->default(0)
                                                ->prefix('Rp. ')
                                                ->readOnly(),
                                        ])
                                        // kirim dua data dalam bentuk array yaitu home_service_id dan price
                                        // di taruh didalam variable setter dan getter yang akan diproses di method updateTotals
                                        // hasilnya id dan price dalam bentuk array
                                        // misal [1 => 100000, 2 => 200000]
                                        ->live()
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            self::updateTotals($get, $set);
                                        })
                                        ->minItems(1)
                                        ->columnSpanFull()
                                        ->label('Choose Product'),
                                ]),
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('sub_total')
                                        ->default(0)
                                        ->prefix('Rp. ')
                                        ->label('Sub Total Amount')
                                        ->readOnly(),
                                    TextInput::make('total_tax_amount')
                                        ->default(0)
                                        ->prefix('Rp. ')
                                        ->label('Total Tax Amount')
                                        ->readOnly(),
                                    TextInput::make('total_amount')
                                        ->default(0)
                                        ->prefix('Rp. ')
                                        ->label('Total Amount')
                                        ->readOnly(),
                                ])
                        ]),
                    Step::make('Customer Information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('For Our Marketing Purposes')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('email')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('phone')
                                        ->required()
                                        ->maxLength(255),
                                ])
                        ]),
                    Step::make('Delivery Information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Where to deliver your product')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('city')
                                        ->label('Kota')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('post_code')
                                        ->label('Kode Pos')
                                        ->required()
                                        ->integer()
                                        ->maxLength(255),
                                    Textarea::make('address')
                                        ->required()
                                        ->label('Alamat Pengerjaan')
                                        ->maxLength(255),
                                    DatePicker::make('schedule_at')
                                        ->required()
                                        ->label('Tanggal Pengerjaan')
                                        ->default(now()->addDays(1)),
                                    TimePicker::make('started_time')
                                        ->required()
                                        ->label('Waktu Mulai Pengerjaan'),

                                ])
                        ]),
                    Step::make('Payment Information')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('Payment Method')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextInput::make('booking_trx_id')
                                        ->required()
                                        ->maxLength(255)
                                        ->readOnly()
                                        ->live()
                                        ->default(BookingTransaction::generateUniqueTrxId()),
                                    ToggleButtons::make('is_paid')
                                        ->label('Status Pembayaran')
                                        ->boolean()
                                        ->grouped()
                                        ->icons([
                                            true => 'heroicon-o-pencil',
                                            false => 'heroicon-o-clock',
                                        ])
                                        ->required(),
                                    FileUpload::make('proof')
                                        ->image()
                                        ->label('Bukti Pembayaran')
                                        ->required()
                                ])
                        ]),
                ])
                    ->columnSpanFull()
                    ->columns(1)
                    ->skippable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_trx_id')
                    ->label('Booking Transaction ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada'),
                IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Status Pembayaran'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->action(function (BookingTransaction $record) {
                        $record->update(['is_paid' => true]);
                        $record->save();

                        Notification::make()
                            ->title('Order Approved')
                            ->success()
                            ->body('The booking transaction has been approved successfully.')
                            ->send();
                    })
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn(BookingTransaction $record) => !$record->is_paid),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relation manager jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
