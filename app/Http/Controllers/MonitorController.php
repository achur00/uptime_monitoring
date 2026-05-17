<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitor;
use App\Http\Requests\StoreMonitorRequest;
use App\Http\Resources\MonitorResource;

class MonitorController extends Controller
{
     public function store(
        StoreMonitorRequest $request
    )
    {
        $monitor = Monitor::create([

            'url' => $request->url,

            'check_interval' => $request->check_interval ?? 5,

            'threshold' => $request->threshold ?? 3,
        ]);

        return response()->json([
            'data' =>
                new MonitorResource(
                    $monitor
                )
        ], 201);
    }
}
