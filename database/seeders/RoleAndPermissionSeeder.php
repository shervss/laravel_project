<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    private const DEFAULT_TEAM_ID = 1;

    /**
     * Seed the application's roles and permissions.
     */
    public function run(): void
    {
        setPermissionsTeamId(self::DEFAULT_TEAM_ID);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (PermissionEnum::cases() as $permission) {
            Permission::findOrCreate($permission->value);
        }

        $superAdmin = Role::findOrCreate(RoleEnum::SUPER_ADMIN->value);
        $admin = Role::findOrCreate(RoleEnum::ADMIN->value);
        $user = Role::findOrCreate(RoleEnum::USER->value);

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            PermissionEnum::VIEW_TODOS->value,
            PermissionEnum::CREATE_TODOS->value,
            PermissionEnum::UPDATE_TODOS->value,
            PermissionEnum::DELETE_TODOS->value,
            PermissionEnum::VIEW_ACTIVITY_LOGS->value,
        ]);

        $user->syncPermissions([
            PermissionEnum::VIEW_TODOS->value,
            PermissionEnum::CREATE_TODOS->value,
            PermissionEnum::UPDATE_TODOS->value,
        ]);

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password']
        )->assignRole(RoleEnum::SUPER_ADMIN->value);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        setPermissionsTeamId(null);
    }
}
