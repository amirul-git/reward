<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('points')->insert([
            'amount' => 0,
            'user_id' => 4
        ]);

        DB::table('points')->insert([
            'amount' => 0,
            'user_id' => 5
        ]);
    }
}
