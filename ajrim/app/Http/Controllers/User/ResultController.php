<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        $results = $user->testResults()
            ->with('test')
            ->whereNotNull('completed_at')
            ->latest()
            ->paginate(10);

        return view('user.results.index', compact('results'));
    }

    public function show(TestResult $result)
    {
        abort_if($result->user_id !== Auth::id(), 403);
        $result->load(['test', 'answers.question']);

        $recommendations = Recommendation::active()
            ->forRisk($result->risk_level)
            ->ordered()
            ->get();

        return view('user.results.show', compact('result', 'recommendations'));
    }
}