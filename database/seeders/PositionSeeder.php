<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create(["name" => "Programmer", "description" => "Develop programs"]);
        Position::create(["name" => "Tester", "description" => "Tests programs"]);
        Position::create(["name" => "Sysadmin", "description" => "Service PC's"]);
        Position::create(["name" => "Analytic", "description" => "Creates a plan"]);
        Position::create(["name" => "Engineer", "description" => "Technical part"]);
    }
}
