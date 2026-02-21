<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        $stats = [
            'completed_tests' => $user->completedTests()->count(),
            'total_tests'     => Test::active()->count(),
            'latest_result'   => $user->testResults()
                ->with('test')
                ->whereNotNull('completed_at')
                ->latest()
                ->first(),
        ];

        $availableTests = Test::active()
            ->withCount(['results as user_completed' => function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereNotNull('completed_at');
            }])
            ->orderBy('order')
            ->get();

        $recentResults = $user->testResults()
            ->with('test')
            ->whereNotNull('completed_at')
            ->latest()
            ->take(3)
            ->get();

        return view('user.dashboard', compact('stats', 'availableTests', 'recentResults'));
    }
}