<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => "admin@gmail.com",
            'password' => Hash::make('password'),
            'role_id'=>1,
            "name"=>"iliass amanar"
        ]);

        DB::table('users')->insert([
            'email' => "member1@gmail.com",
            'password' => Hash::make('password'),
            'role_id'=>2,
            "name"=>"member1 xxxx"
        ]);
        DB::table('users')->insert([
            'email' => "member2@gmail.com",
            'password' => Hash::make('password'),
            'role_id'=>2,
            "name"=>"member1 xxxx"
        ]);
    }
}
