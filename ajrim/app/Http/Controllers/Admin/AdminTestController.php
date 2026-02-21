<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class AdminTestController extends Controller
{
    public function index()
    {
        $tests = Test::withCount(['questions', 'results'])->orderBy('order')->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $categories = Test::$categories;
        return view('admin.tests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'emoji'            => ['required', 'string', 'max:10'],
            'color'            => ['required', 'string', 'max:20'],
            'category'         => ['required', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:120'],
            'order'            => ['nullable', 'integer'],
            'is_active'        => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? (Test::max('order') + 1);

        Test::create($validated);

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test muvaffaqiyatli yaratildi');
    }

    public function show(Test $test)
    {
        $test->load(['questions.options', 'results.user']);
        return view('admin.tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        $categories = Test::$categories;
        return view('admin.tests.edit', compact('test', 'categories'));
    }

    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'emoji'            => ['required', 'string', 'max:10'],
            'color'            => ['required', 'string', 'max:20'],
            'category'         => ['required', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:120'],
            'order'            => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $test->update($validated);

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test muvaffaqiyatli yangilandi');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('admin.tests.index')
            ->with('success', 'Test o\'chirildi');
    }

    public function toggleActive(Test $test)
    {
        $test->update(['is_active' => !$test->is_active]);
        $message = $test->is_active ? 'Test yoqildi' : 'Test o\'chirildi';
        return back()->with('success', $message);
    }
}