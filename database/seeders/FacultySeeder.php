<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            ['name'=> "teset"],
            ['name'=> "elit"],
            ['name'=> "biem"],
            ['name'=> "ifsk"],
            ['name'=> "nnip"],
            ['name'=> "nnmi"],
        ];

        foreach($faculties as $faculty)
        {
            Faculty::create($faculty);
        }
    }
}
