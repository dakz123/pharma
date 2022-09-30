<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=[[
            'name' => 'adminA',
            'email' => 'adminA@admin.com',
            'password' => Hash::make('password'),
            'role' => 1,
            'department' => 1,
            
        ],[
            'name' => 'adminB',
            'email' => 'adminB@admin.com',
            'password' => Hash::make('password'),
            'role' => 1,
            'department' => 2,

        ],[
            'name' => 'adminC',
            'email' => 'adminC@admin.com',
            'password' => Hash::make('password'),
            'role' => 1,
            'department' => 3,
        ],[
            'name' => 'adminD',
            'email' => 'adminD@admin.com',
            'password' => Hash::make('password'),
            'role' => 1,
            'department' => 4,
        ]];
        DB::table('users')->insert($admin);
    }
}
