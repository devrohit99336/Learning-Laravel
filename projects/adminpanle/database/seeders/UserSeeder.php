<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'employee',
                'email' => 'employee@employee.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => bcrypt('password'),
            ],

        );

        Role::insert(
            ['name' => 'admin','slug' => 'admin'],
            ['name' => 'employee','slug' => 'employee'],
            ['name' => 'user','slug' => 'user'],
        );

        Permission::insert(
            ['name' => 'create','slug' => 'create'],
            ['name' => 'read','slug' => 'read'],
            ['name' => 'update','slug' => 'update'],
            ['name' => 'delete','slug' => 'delete'],
        );
    }
}
