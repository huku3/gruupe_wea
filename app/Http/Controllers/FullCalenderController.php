<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Schedule;

class FullCalenderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Schedule::whereDate('start_date', '>=', $request->start_date)
                ->whereDate('end_date',   '<=', $request->end_date)
                ->get(['id', 'event_name', 'start_date', 'end_date']);
            return response()->json($data);
        }
        return view('full-calender');
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->type == 'add') {
                // $event = [
                //     'event_name'        =>    'aaaa',
                //     'start_date'        =>    '2010-01-01 00:00:00',
                //     'end_date'        =>    '2010-01-01 00:00:00',
                // ];
                $event = Schedule::create([
                    'event_name'        =>    $request->event_name,
                    'start_date'        =>    $request->start_date,
                    'end_date'        =>    $request->end_date
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Schedule::find($request->id)->update([
                    'event_name'        =>    $request->event_name,
                    'start_date'        =>    $request->start_date,
                    'end_date'        =>    $request->end_date
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Schedule::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
}
