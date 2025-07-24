<?php

namespace App\Filament\Resources\UsersResource\Pages;

use Filament\Actions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\UsersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    // assign role and permission di create user

    // assign role
    protected function afterCreate()
    {
        $user = $this->record;

        $roles = $this->data['roles'] ?? [];
        $newRoles = [];
        foreach ($roles as $role) {
            $role = Role::firstOrCreate(['name' => $role['name'], 'guard_name' => 'web']);
            $newRoles[] = $role->name;
        }
        $user->syncRoles($newRoles);
        $user->assignRole($newRoles);


        $permissions = $this->data['permissions'] ?? [];
        $newPermissions = [];
        foreach ($permissions as $permission) {
            if (isset($permission['name'])) {
                $permission = Permission::firstOrCreate(['name' => $permission['name'], 'guard_name' => 'web']);
                $newPermissions[] = $permission->name;
            }
            $user->syncPermissions($newPermissions);
            $user->givePermissionTo($newPermissions);
        }
    }
}
