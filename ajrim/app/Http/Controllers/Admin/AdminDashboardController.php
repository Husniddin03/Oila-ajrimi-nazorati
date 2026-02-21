<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'   => User::where('role', 'user')->count(),
            'active_users'  => User::where('role', 'user')->where('status', 'active')->count(),
            'total_tests'   => Test::count(),
            'total_results' => TestResult::whereNotNull('completed_at')->count(),
            'high_risk'     => TestResult::where('risk_level', 'high')->whereNotNull('completed_at')->count(),
            'medium_risk'   => TestResult::where('risk_level', 'medium')->whereNotNull('completed_at')->count(),
            'low_risk'      => TestResult::where('risk_level', 'low')->whereNotNull('completed_at')->count(),
        ];

        $recentResults = TestResult::with(['user', 'test'])
            ->whereNotNull('completed_at')
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Monthly results chart data
        $monthlyData = TestResult::whereNotNull('completed_at')
            ->where('completed_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('MONTH(completed_at) as month'),
                DB::raw('YEAR(completed_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentResults', 'recentUsers', 'monthlyData'));
    }
}
