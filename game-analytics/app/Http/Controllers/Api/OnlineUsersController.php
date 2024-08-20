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
        
        if ($latestCount) {
            return response()->json(['count' => $latestCount->count]);
        }
    
        return response()->json(['count' => 0], 200);
    }
        

    public function chartData()
    {
        $data = OnlineUser::where('retrieved_at', '>=', now()->subDay())
                        ->orderBy('retrieved_at')
                        ->get(['count', 'retrieved_at']);

        if ($data->isEmpty()) {
            return response()->json(['data' => []], 200);
        }

        return response()->json($data);
    }

    public function tableData()
    {
        $data = OnlineUser::selectRaw('DATE(retrieved_at) as date, MAX(count) as peak_users, AVG(count) as average_users')
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->get();

        if ($data->isEmpty()) {
            return response()->json(['data' => []], 200);
        }

        return response()->json($data);
    }

}