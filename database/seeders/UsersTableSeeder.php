<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate([
            "name" => "SYSTEM",
        ], [
            "phone_number" => "+251916667538",
            "email" => "abenezer.ayalneh.42@gmail.com",
            "role_id" => 1,
            "created_by" => 1,
            "updated_by" => 1,
        ]);
    }
}
