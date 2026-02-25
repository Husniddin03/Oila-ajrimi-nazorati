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
            if ($question->question_type === 'multiple_choice') {
                $rules["answers.{$question->id}"] = ['required', 'array'];
                $rules["answers.{$question->id}.*"] = ['required', 'integer', 'min:1', 'max:5'];
            } elseif ($question->question_type === 'text') {
                $rules["answers.{$question->id}"] = ['required', 'string', 'min:1'];
            } else {
                // Scale and single choice
                $rules["answers.{$question->id}"] = ['required', 'integer', 'min:1', 'max:5'];
            }
        }
        $request->validate($rules, [
            'answers.*.required' => 'Barcha savollarga javob bering',
            'answers.*.min' => 'Javob to\'g\'ri kiriting',
            'answers.*.max' => 'Javob to\'g\'ri kiriting',
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
            $answer = $answers[$question->id] ?? null;

            // Create answer data based on question type
            $answerData = [
                'test_result_id' => $result->id,
                'question_id'    => $question->id,
            ];

            if ($question->question_type === 'text') {
                // Text question - save to text_answer column
                $answerData['text_answer'] = $answer;
                // For scoring, use default value 3 for text answers
                $numericValue = 3;
            } elseif ($question->question_type === 'multiple_choice') {
                // Multiple choice - save as array or comma-separated
                if (is_array($answer)) {
                    $answerData['text_answer'] = implode(',', $answer);
                    // Calculate average for scoring
                    $numericValue = count($answer) > 0 ? array_sum($answer) / count($answer) : 3;
                } else {
                    $numericValue = 3;
                }
            } else {
                // Scale or single choice - save to numeric_value
                $numericValue = is_numeric($answer) ? (int)$answer : 3;
                $answerData['numeric_value'] = $numericValue;
            }

            // Set numeric_value for non-text questions
            if ($question->question_type !== 'text') {
                $answerData['numeric_value'] = $numericValue;
            }

            TestAnswer::create($answerData);

            $tag = $question->category_tag ?? 'muloqot';
            if (isset($scores[$tag])) {
                $scores[$tag][] = (int)$numericValue;
            } else {
                $scores['muloqot'][] = (int)$numericValue;
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
