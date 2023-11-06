<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('receipt_statuses')->insert([
            'name' => "requested"
        ]);

        DB::table('receipt_statuses')->insert([
            'name' => "accepted"
        ]);

        DB::table('receipt_statuses')->insert([
            'name' => "rejected"
        ]);
    }
}
