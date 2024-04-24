<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "login" => "gr414_zdyuva",
            "password" => bcrypt("qweasd123"),
            "role" => "admin"
        ]);
        User::create([
            "login" => "yuriy",
            "password" => bcrypt("qweasd123"),
            "role" => "moderator"
        ]);
    }
}
