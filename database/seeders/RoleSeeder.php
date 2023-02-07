<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $jsonFilePath = __DIR__."/json/roles.json";

        if(file_exists($jsonFilePath)) {

            $jsonString = file_get_contents($jsonFilePath);

            if($jsonString !== false) {

                $roleList = json_decode($jsonString, true);
                $existingRoleList = Role::all(['name'])->toArray();
                $currentTimestamp = \Carbon\Carbon::now()->toDateTimeString();

                foreach ($roleList as $role)
                {
                    $rolePermissionsList = $roleRestrictionsList = null;

                    unset($role['description']);
                    unset($role['level']);

                    if(array_key_exists('permissions', $role)) {
                        $rolePermissionsList = $role['permissions'];
                        unset($role['permissions']);
                    }
                    if(array_key_exists('restrictions', $role)) {
                        $roleRestrictionsList = $role['restrictions'];
                        unset($role['restrictions']);
                    }

                    if(false === in_array($role['name'], array_column($existingRoleList, 'name')))
                    {
                        $role['created_at'] = $currentTimestamp;
                        $role['guard_name'] = 'web';
                        Role::insert($role);
                    } else{
                        Role::where('name', $role['name'])
                            ->update($role);
                    }

                    $roleObj = Role::where('name', '=', $role['name'])->firstOrFail();

                    if(!empty($rolePermissionsList)) {

                        if($rolePermissionsList == '*') {
                            $permissions = Permission::pluck('id', 'id')->all();
                        } else {
                            $permissions = Permission::whereIn('name', $rolePermissionsList)->pluck('id', 'id')->all();
                        }

                        $roleObj->syncPermissions($permissions);

                    }else if(!empty($roleRestrictionsList)) {

                        $permissions = Permission::whereNotIn('name', $roleRestrictionsList)->pluck('id', 'id')->all();

                        $roleObj->syncPermissions($permissions);
                    }
                }
            }
        }
    }
}
