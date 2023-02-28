<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tachsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taches')->insert([
            'admin' =>1,
            'member' =>2,
            'project_id'=>1,
            "description"=>"description tache 1 ",
            "status"=> "pending"
        ]);
        DB::table('taches')->insert([
            'admin' =>1,
            'member' =>3,
            'project_id'=>1,
            "description"=>"description tache 1 ",
            "status"=> "pending"
        ]);
    }
}
