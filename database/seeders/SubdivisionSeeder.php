<?php

namespace Database\Seeders;

use App\Models\Subdivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubdivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subdivision::create(["subdivision_code" => '11', "name" => "Technical", "description" => "Hardware work"]);
        Subdivision::create(["subdivision_code" => '12', "name" => "Develop", "description" => "Software work"]);
    }
}
