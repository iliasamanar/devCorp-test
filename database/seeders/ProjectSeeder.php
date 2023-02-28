<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            'user_id' => 1,
            'title' => "Project 1",
            'description'=> "Project 1 ........",
        ]);

        DB::table('projects')->insert([
            'user_id' => 1,
            'title' => "Project 2",
            'description'=> "Project 1 ........",
        ]);
    }
}
