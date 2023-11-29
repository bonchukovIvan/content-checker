<?php

namespace Database\Seeders;

use App\Models\Departament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            ['name'=> "інституту/факультету"],
            ['name'=> "випускова"],
            ['name'=> "невипускова"],
        ];

        DB::table('departament')->insert($faculties);
    }
}
