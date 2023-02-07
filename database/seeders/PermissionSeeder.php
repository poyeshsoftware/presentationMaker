<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $jsonFilePath = __DIR__ . "/json/permissions.json";

        if (file_exists($jsonFilePath)) {

            $jsonString = file_get_contents($jsonFilePath);

            if ($jsonString !== false) {

                $list = json_decode($jsonString, true);
                $existingList = Permission::all(['name'])->toArray();
                $currentTimestamp = \Carbon\Carbon::now()->toDateTimeString();

                foreach ($list as $item) {
                    if (false === in_array($item['name'], array_column($existingList, 'name'))) {
                        unset($item['description']);
                        $item['created_at'] = $currentTimestamp;
                        $item['guard_name'] = 'web';
                        Permission::insert($item);
                    } else {
                        Permission::where('name', $item['name'])
                            ->update($item);
                    }
                }
            }
        }
    }
}
