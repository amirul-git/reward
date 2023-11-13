<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reward_statuses')->insert([
            'name' => 'created',
        ]);

        DB::table('reward_statuses')->insert([
            'name' => 'exchanged',
        ]);
    }
}
