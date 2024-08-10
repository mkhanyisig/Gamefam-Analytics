<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OnlineUser;
use Illuminate\Http\Request;

class OnlineUsersController extends Controller
{
    
    public function liveCount()
    {
        $latestCount = OnlineUser::latest()->first();
        return response()->json(['count' => $latestCount->count]);
    }
        

    public function chartData()
    {
        $data = OnlineUser::where('retrieved_at', '>=', now()->subDay())
                          ->orderBy('retrieved_at')
                          ->get(['count', 'retrieved_at']);

        return response()->json($data);
    }

    public function tableData()
    {
        $data = OnlineUser::selectRaw('DATE(retrieved_at) as date, MAX(count) as peak_users, AVG(count) as average_users')
                          ->groupBy('date')
                          ->orderBy('date', 'desc')
                          ->limit(7)
                          ->get();

        return response()->json($data);
    }
}