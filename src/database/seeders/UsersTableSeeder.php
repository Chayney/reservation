<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ];

        DB::table('users')->insert($param);

        User::factory()->count(9)->create();
    }
}