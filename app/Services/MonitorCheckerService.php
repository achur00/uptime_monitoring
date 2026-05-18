<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MonitorCheckerService
{
    public function check(string $url): array
    {
        try {

            $start = microtime(true);

            $response = Http::timeout(10)->get($url);

            $time = round(
                (microtime(true) - $start) * 1000
            );

            $statusCode = $response->status();

            $isUp = $statusCode >= 200 && $statusCode < 400;

            return [
                'status_code' => $statusCode,
                'response_time_ms' => $time,
                'is_up' => $isUp
            ];

        } catch (\Exception $e) {

            return [
                'status_code' => 0,
                'response_time_ms' => null,
                'is_up' => false
            ];
        }
    }
}