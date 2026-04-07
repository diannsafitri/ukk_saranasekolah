<?php

namespace App\Http\Controllers;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show user dashboard
     */
    public function index()
    {
        $userId = auth()->id();

        $aspirasiCount = Aspirasi::where('user_id', $userId)->count();
        $pendingCount = Aspirasi::where('user_id', $userId)->where('status', 'pending')->count();
        $processingCount = Aspirasi::where('user_id', $userId)->where('status', 'processing')->count();
        $completedCount = Aspirasi::where('user_id', $userId)->where('status', 'completed')->count();

        return view('dashboard', compact('aspirasiCount', 'pendingCount', 'processingCount', 'completedCount'));
    }
}