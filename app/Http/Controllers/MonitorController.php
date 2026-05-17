<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitor;
use App\Http\Requests\StoreMonitorRequest;
use App\Http\Resources\MonitorResource;
use App\Http\Resources\MonitorEventResource;
use App\Models\MonitorEvent;

class MonitorController extends Controller
{
    public function index(){
        //return collection in desc order
        $monitors = Monitor::latest()->get();

        return response()->json(['data' => MonitorResource::collection($monitors)], 200);
    }


     public function store(
        //use validate request
        StoreMonitorRequest $request
    )
    {
        $monitor = Monitor::create([

            'url' => $request->url,

            'check_interval' => $request->check_interval ?? 5,

            'threshold' => $request->threshold ?? 3,
        ]);
        //return the newly created monitor using the structured resource with a 201 status code
        return response()->json(['data' => new MonitorResource($monitor)], 201);

    }

}
