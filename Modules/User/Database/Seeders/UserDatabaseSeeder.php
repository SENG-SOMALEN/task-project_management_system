<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);

        $users = [
            [
                'username'   => 'Malen',
                'gender'     => 'Male',
                'email'      => 'malen@gmail.com',
                'password'   => Hash::make('123456'),
                'role'       => 'Admin',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
