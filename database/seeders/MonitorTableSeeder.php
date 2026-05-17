<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Monitor;
class MonitorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'url' => 'https://www.google.com',
                'check_interval' => 5,
                'threshold' => 3,
                'status' => 'up',
            ],
            [
                'url' => 'https://www.facebook.com',
                'check_interval' => 10,
                'threshold' => 5,
                'status' => 'up',
            ],
            [
                'url' => 'https://www.twitter.com',
                'check_interval' => 15,
                'threshold' => 2,
                'status' => 'up',
            ],
        ];

        foreach ($data as $monitor) {
          Monitor::create($monitor);
        }
    }
}
