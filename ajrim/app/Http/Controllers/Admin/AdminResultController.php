<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use Illuminate\Http\Request;

class AdminResultController extends Controller
{
    public function index(Request $request)
    {
        $query = TestResult::with(['user', 'test'])
            ->whereNotNull('completed_at');

        if ($request->risk_level) {
            $query->where('risk_level', $request->risk_level);
        }

        if ($request->test_id) {
            $query->where('test_id', $request->test_id);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $results = $query->latest('completed_at')->paginate(15);

        $allTests = \App\Models\Test::pluck('title', 'id');

        return view('admin.results.index', compact('results', 'allTests'));
    }

    public function show(TestResult $result)
    {
        $result->load(['user', 'test', 'answers.question']);
        return view('admin.results.show', compact('result'));
    }

    public function destroy(TestResult $result)
    {
        $result->delete();
        return redirect()->route('admin.results.index')
            ->with('success', 'Natija o\'chirildi');
    }
}