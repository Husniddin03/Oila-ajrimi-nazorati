<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\TestAnswer;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());

        $tests = Test::active()
            ->with('questions')
            ->withCount(['results as user_completed' => function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereNotNull('completed_at');
            }])
            ->orderBy('order')
            ->get();

        return view('user.tests.index', compact('tests'));
    }

    public function show(Test $test)
    {
        abort_if(!$test->is_active, 404);
        $test->load('questions.options');
        $alreadyDone = TestResult::where('user_id', Auth::id())
            ->where('test_id', $test->id)
            ->whereNotNull('completed_at')
            ->exists();

        return view('user.tests.show', compact('test', 'alreadyDone'));
    }

    public function start(Test $test)
    {
        abort_if(!$test->is_active, 404);
        $test->load(['activeQuestions.options']);

        return view('user.tests.start', compact('test'));
    }

    public function submit(Request $request, Test $test)
    {
        abort_if(!$test->is_active, 404);

        $questions = $test->activeQuestions()->get();

        // Validate that all questions are answered
        $rules = [];
        foreach ($questions as $question) {
            $rules["answers.{$question->id}"] = ['required'];
        }
        $request->validate($rules, [
            'answers.*.required' => 'Barcha savollarga javob bering',
        ]);

        $answers = $request->input('answers', []);

        // Calculate scores by category
        $scores = ['emotsional' => [], 'moliyaviy' => [], 'muloqot' => []];

        $result = TestResult::create([
            'user_id'    => Auth::id(),
            'test_id'    => $test->id,
            'risk_level' => 'medium',
            'completed_at' => now(),
        ]);

        foreach ($questions as $question) {
            $value = $answers[$question->id] ?? 3;

            TestAnswer::create([
                'test_result_id' => $result->id,
                'question_id'    => $question->id,
                'numeric_value'  => $value,
            ]);

            $tag = $question->category_tag ?? 'muloqot';
            if (isset($scores[$tag])) {
                $scores[$tag][] = (int)$value;
            } else {
                $scores['muloqot'][] = (int)$value;
            }
        }

        // Convert to 0-100%
        $toPercent = fn($arr) => count($arr)
            ? round(array_sum($arr) / (count($arr) * 5) * 100, 2)
            : 50;

        $em  = $toPercent($scores['emotsional']);
        $fin = $toPercent($scores['moliyaviy']);
        $com = $toPercent($scores['muloqot']);
        $avg = round(($em + $fin + $com) / 3, 2);

        $result->update([
            'score_emotional'    => $em,
            'score_financial'    => $fin,
            'score_communication' => $com,
            'score_average'      => $avg,
            'risk_level'         => TestResult::calculateRisk($avg),
        ]);

        return redirect()->route('user.results.show', $result)
            ->with('success', 'Test muvaffaqiyatli yakunlandi!');
    }
}
