<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_bank","view_any_bank","create_bank","update_bank","delete_bank","view_branch","view_any_branch","create_branch","update_branch","delete_branch","view_contact::submission","view_any_contact::submission","view_offer","view_any_offer","create_offer","update_offer","delete_offer","view_page","view_any_page","create_page","update_page","delete_page","view_post","view_any_post","create_post","update_post","delete_post","view_post::category","view_any_post::category","create_post::category","update_post::category","delete_post::category","view_purchase::application","view_any_purchase::application","view_user","view_any_user","create_user","update_user","delete_user","view_vehicle","view_any_vehicle","create_vehicle","update_vehicle","delete_vehicle","view_vehicle::brand","view_any_vehicle::brand","create_vehicle::brand","update_vehicle::brand","delete_vehicle::brand","view_vehicle::category","view_any_vehicle::category","create_vehicle::category","update_vehicle::category","delete_vehicle::category","page_AboutPage","page_CalculatorSettings","page_ContactPage","page_FAQSettings","page_GeneralSettings","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role"]}]';
        $directPermissions = '{"12":{"name":"create_contact::submission","guard_name":"web"},"13":{"name":"update_contact::submission","guard_name":"web"},"14":{"name":"delete_contact::submission","guard_name":"web"},"37":{"name":"create_purchase::application","guard_name":"web"},"38":{"name":"update_purchase::application","guard_name":"web"},"39":{"name":"delete_purchase::application","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
