<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MonitorEvent;

class MonitorEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'monitor_id' => 1,
                'status_code' => 200,
                'response_time_ms' => 150,
                'is_up' => true,
                'checked_at' => now(),
            ],
            [
                'monitor_id' => 1,
                'status_code' => 500,
                'response_time_ms' => 300,
                'is_up' => false,
                'checked_at' => now()->subMinutes(5),
            ],
            [
                'monitor_id' => 2,
                'status_code' => 200,
                'response_time_ms' => 100,
                'is_up' => true,
                'checked_at' => now(),
            ],
        ];

        foreach ($data as $event) {
         MonitorEvent::create($event);
        }
    }
}
