<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index(Test $test)
    {
        $questions = $test->questions()->with('options')->get();
        return view('admin.questions.index', compact('test', 'questions'));
    }

    public function create(Test $test)
    {
        return view('admin.questions.create', compact('test'));
    }

    public function store(Request $request, Test $test)
    {
        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'question_type' => ['required', 'in:scale,single_choice,multiple_choice,text'],
            'category_tag'  => ['nullable', 'in:emotsional,moliyaviy,muloqot'],
            'order'         => ['nullable', 'integer'],
            'options'       => ['nullable', 'array'],
            'options.*.text'  => ['required_with:options', 'string'],
            'options.*.value' => ['required_with:options', 'integer', 'min:1', 'max:5'],
        ]);

        $question = $test->questions()->create([
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'category_tag'  => $validated['category_tag'] ?? 'muloqot',
            'order'         => $validated['order'] ?? ($test->questions()->max('order') + 1),
            'is_active'     => true,
        ]);

        // If single/multiple choice - save options
        if (in_array($validated['question_type'], ['single_choice', 'multiple_choice'])) {
            foreach ($request->options ?? [] as $i => $opt) {
                if (!empty($opt['text'])) {
                    $question->options()->create([
                        'option_text' => $opt['text'],
                        'value'       => $opt['value'] ?? ($i + 1),
                        'order'       => $i,
                    ]);
                }
            }
        }

        return redirect()->route('admin.tests.questions.index', $test)
            ->with('success', 'Savol muvaffaqiyatli qo\'shildi');
    }

    public function edit(Test $test, Question $question)
    {
        $question->load('options');
        return view('admin.questions.edit', compact('test', 'question'));
    }

    public function update(Request $request, Test $test, Question $question)
    {
        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'question_type' => ['required', 'in:scale,single_choice,multiple_choice,text'],
            'category_tag'  => ['nullable', 'in:emotsional,moliyaviy,muloqot'],
            'order'         => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $question->update($validated);

        // Update options
        if (in_array($validated['question_type'], ['single_choice', 'multiple_choice'])) {
            $question->options()->delete();
            foreach ($request->options ?? [] as $i => $opt) {
                if (!empty($opt['text'])) {
                    $question->options()->create([
                        'option_text' => $opt['text'],
                        'value'       => $opt['value'] ?? ($i + 1),
                        'order'       => $i,
                    ]);
                }
            }
        }

        return redirect()->route('admin.tests.questions.index', $test)
            ->with('success', 'Savol yangilandi');
    }

    public function destroy(Test $test, Question $question)
    {
        $question->delete();
        return back()->with('success', 'Savol o\'chirildi');
    }
}