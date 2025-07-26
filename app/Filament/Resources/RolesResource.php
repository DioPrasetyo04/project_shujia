<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RolesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RolesResource\RelationManagers;

class RolesResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-s-information-circle';

    protected static ?string $navigationGroup = 'Users Managements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Role Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Role Name'),
                        Select::make('guard_name')
                            ->options([
                                'web' => 'Web',
                                'api' => 'API',
                            ])
                            ->default('web')
                            ->label('Guard Name')
                            ->required(),
                    ]),
                Fieldset::make('Detail Permissions')
                    ->schema([
                        Repeater::make('permissions')
                            ->relationship('permissions')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Permission Name'),
                                Select::make('guard_name')
                                    ->options([
                                        'web' => 'Web',
                                        'api' => 'API',
                                    ])
                                    ->default('web')
                                    ->label('Guard Name')
                                    ->required(),
                            ])
                            ->required()
                            ->defaultItems(2)
                            ->grid(2)
                            ->reorderable()
                            ->columns([
                                'name' => 'Permission Name',
                                'guard_name' => 'Guard Name',
                            ])->columnSpanFull()
                            ->AddActionLabel('Add Permission'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Role Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guard_name')
                    ->label('Guard Role')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    // ->formatStateUsing(fn($state) => implode(', ', $state))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
                // filter addtional category
                SelectFilter::make('name')
                    ->relationship('Permissions', 'name')
                    ->label('Permissions')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('guard_name')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ])
                    ->label('Guard Name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRoles::route('/create'),
            'edit' => Pages\EditRoles::route('/{record}/edit'),
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
