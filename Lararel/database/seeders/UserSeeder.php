<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contact;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'John@test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
        ]);


        Contact::create([
            'address' => '123 Main St',
            'phone' => '123-456-7890',
            'user_id' => 1,
        ]);

    }
}
