<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'status_name' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_name' => 'Processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_name' => 'Completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_name' => 'Cancel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('order_status')->insert($statuses);
    }
}
