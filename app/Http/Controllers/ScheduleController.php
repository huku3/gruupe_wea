<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Schedule::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        return view('full-calender');
    }

    /**
     * イベントを登録
     *
     * @param  Request  $request
     */
    public function store(Request $request)
    {
        // バリデーション
        // $request->validate([
        //     'start' => 'required|integer',
        //     'end' => 'required|integer',
        //     'title' => 'required|max:32',
        // ]);

        // 登録処理
        $schedule = new Schedule;
        // 日付に変換。JavaScriptのタイムスタンプはミリ秒なので秒に変換
        // $schedule->start_date = "2018-01-01 00:00:00";
        // $schedule->end_date = "2018-01-01 01:00:00";
        // $schedule->event_name = "sadfa";
        $schedule->start_date = $request->input('start');
        $schedule->end_date = $request->input('end');
        $schedule->event_name = $request->input('title');
        $schedule->save();

        return;
    }
}
