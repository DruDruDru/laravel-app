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

        Position::where('name', 'Programmer')
            ->first()->employees()->attach([1, 2, 3, 4, 5]);
        Position::where('name', 'Tester')
            ->first()->employees()->attach([5, 6]);
        Position::where('name', 'Sysadmin')
            ->first()->employees()->attach([5, 6, 7]);
        Position::where('name', 'Analytic')
            ->first()->employees()->attach([8]);
        Position::where('name', 'Engineer')
            ->first()->employees()->attach([9, 10]);
    }
}
