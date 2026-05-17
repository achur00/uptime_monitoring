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


    public function history(Request $request, int $id)
    {
        $monitor = Monitor::find($id);
        
        //if id not found return 404 with message
        if (!$monitor) {
            return response()->json(['message' =>'Monitor not found.' ], 404);
        }
        //minimum of 15 and maximum of 100 per page (requirement)
        $perPage = min($request->input('per_page',  15 ), 100 );
        
        ///paginate/load chunk the history of monitor events for the given monitor id in descending order of checked_at
        $history = MonitorEvent::where('monitor_id', $id )->orderByDesc('checked_at')->paginate($perPage);

        return response()->json([
            'data' =>
                MonitorEventResource::collection(
                    //items() method to get the collection of items for the current page from the paginated result
                    //items can be use in place of get() when we are paginating results
                    $history->items()
                ),

            'meta' => [
                'current_page' =>
                //currentPage() method to get the current page number from the paginated result
                    $history->currentPage(),

                'per_page' =>
                //perpage() method to get the number of items per page from the paginated result
                    $history->perPage(),

                'total' =>
                //total() method to get the total number of items from the paginated result
                    $history->total(),
            ]
        ]);
    }
}
