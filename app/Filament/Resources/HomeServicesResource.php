<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HomeService;
use App\Models\HomeServices;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HomeServicesResource\Pages;
use App\Filament\Resources\HomeServicesResource\RelationManagers;

class HomeServicesResource extends Resource
{
    protected static ?string $model = HomeService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        FileUpload::make('thumbnail')
                            ->label('Photo')
                            ->image()
                            ->required(),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->prefix('Rp.')
                            ->required(),
                        TextInput::make('duration')
                            ->label('Duration')
                            ->numeric()
                            ->prefix('Hours')
                    ]),
                Fieldset::make('Addtional')
                    ->schema([
                        Repeater::make('benefits')
                            ->Label('Benefits')
                            ->relationship('benefits')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Benefit Name')
                                    ->required(),
                                FileUpload::make('photo')
                                    ->label('Benefit Image')
                                    ->image()
                                    ->required(),
                            ])
                            // default item yang akan tampil
                            ->defaultItems(4)
                            // label tombol
                            ->addActionLabel('Add Benefit')
                            // fitur untuk mengurutkan item
                            ->reorderable()
                            // fitur untuk clone item
                            ->cloneable()
                            ->grid(2)
                            // column span full
                            ->columns([
                                'name' => 'Benefit Name',
                                'photo' => 'Benefit Image',
                            ])->columnSpanFull(),
                        Textarea::make('about')
                            ->label('About')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('is_popular')
                            ->label('Is Popular')
                            ->options([
                                true => 'Popular',
                                false => 'Not Popular',
                            ])
                            ->required(),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label('Category')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(50),
                // relationship dengan category dan mengambil name
                TextColumn::make('category.name'),
                TextColumn::make('name')
                    ->label('Service Name')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_popular')
                    ->label('Popular')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                ImageColumn::make('benefits.photo')
                    ->label('Benefit Image')
                    ->circular()
                    ->size(50),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                // filter addtional category
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(), // This line is added to enable the view action
            ])
            // TODO: Add columns here
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Enable filtering of trashed records

                    // Filters
                    Tables\Actions\DeleteBulkAction::make(),
                    // Enable editing
                    // Enable soft deleting
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    // Enable soft deleting and force deleting
                    Tables\Actions\RestoreBulkAction::make(),

                    // Actions
                ]),
                // Enable editing
            ]);
    }

    // Bulk Actions

    // Enable bulk deleting, force deleting, and restoring
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeServices::route('/'),
            'create' => Pages\CreateHomeServices::route('/create'),
            'edit' => Pages\EditHomeServices::route('/{record}/edit'),
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
