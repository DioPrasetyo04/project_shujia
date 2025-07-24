<?php

namespace App\Filament\Resources\UsersResource\Pages;

use Filament\Actions;
use Spatie\Permission\Models\Role;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UsersResource;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function afterSave()
    {
        $user = $this->record;

        $roles = $this->data['roles'] ?? [];
        $newRoles = [];
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $newRoles[] = $role->name;
        }
        $user->syncRoles($newRoles);

        $permissions = $this->data['permissions'] ?? [];
        $newPermissions = [];
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
            $newPermissions[] = $permission->name;
        }
        $user->syncPermissions($newPermissions);
    }
}
