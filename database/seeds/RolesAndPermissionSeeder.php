<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // flush the cache
        app()['cache']->forget('spatie.permission.cache');

        // create food plan permissions
        Permission::create(['name' => 'view foodplan']);
        Permission::create(['name' => 'create foodplan']);
        Permission::create(['name' => 'delete foodplan']);
        Permission::create(['name' => 'update foodplan']);
        Permission::create(['name' => 'edit foodplan']);

        // create exerciseplan permissions
        Permission::create(['name' => 'view exerciseplan']);
        Permission::create(['name' => 'create exerciseplan']);
        Permission::create(['name' => 'delete exerciseplan']);
        Permission::create(['name' => 'update exerciseplan']);
        Permission::create(['name' => 'edit exerciseplan']);

        // create schedule permissions
        Permission::create(['name' => 'view schedule']);
        Permission::create(['name' => 'create schedule']);
        Permission::create(['name' => 'delete schedule']);
        Permission::create(['name' => 'update schedule']);
        Permission::create(['name' => 'edit schedule']);

        // create roles and assign permissions to them
        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo(['view foodplan',
                                'create foodplan',
                                'delete foodplan',
                                'update foodplan',
                                'edit foodplan',
                                'view exerciseplan',
                                'create exerciseplan',
                                'delete exerciseplan',
                                'update exerciseplan',
                                'edit exerciseplan',
                                'view schedule',
                                'create schedule',
                                'delete schedule',
                                'update schedule',
                                'edit schedule']);

        $role = Role::create(['name' => 'trainer']);
        $role->givePermissionTo(['view foodplan',
                                'create foodplan',
                                'delete foodplan',
                                'update foodplan',
                                'edit foodplan',
                                'view exerciseplan',
                                'create exerciseplan',
                                'delete exerciseplan',
                                'update exerciseplan',
                                'edit exerciseplan',
                                'view schedule',
                                'create schedule',
                                'delete schedule',
                                'update schedule',
                                'edit schedule']);

        $role = Role::create(['name' => 'client']);
        $role->givePermissionTo(['view foodplan', 'view exerciseplan', 'view schedule']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
