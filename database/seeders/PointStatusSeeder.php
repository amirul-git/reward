<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('point_statuses')->insert([
            'name' => "in"
        ]);

        DB::table('point_statuses')->insert([
            'name' => "out"
        ]);
    }
}
