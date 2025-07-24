<?php

namespace App\Filament\Resources;

use Filament\Forms;
use TextInput\Mask;
use App\Models\User;
use Filament\Tables;
use App\Models\Users;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UsersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UsersResource\RelationManagers;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('User Details')
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255)
                            ->label('Full Name'),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->label('Email Address'),
                        TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->label('Password')
                            ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                        // Verifikasi Email
                        DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->default(now())
                            ->required(),
                    ]),
                Fieldset::make('Detail Roles & Permission')
                    ->schema([
                        Select::make('roles')
                            ->options(Role::all()->pluck('name', 'name'))
                            ->relationship('roles', 'name')
                            ->preload()
                            ->label('Role Name')
                            // menjadikan record menjadi array multiple yang bisa diisi lebih dari satu role
                            ->multiple(),
                        Select::make('permissions')
                            ->options(Permission::all()->pluck('name', 'name'))
                            ->relationship('permissions', 'name')
                            ->preload()
                            ->label('Permission Name')
                            // menjadikan record menjadi array multiple yang bisa diisi lebih dari satu permission
                            ->multiple(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
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
