<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
            "email" => "abene42@gmail.com",
            "created_by" => 1,
            "updated_by" => 1,
        ]);
    }
}
