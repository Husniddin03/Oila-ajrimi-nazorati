<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class AdminRecommendationController extends Controller
{
    public function index()
    {
        $recommendations = Recommendation::ordered()->paginate(15);
        return view('admin.recommendations.index', compact('recommendations'));
    }

    public function create()
    {
        return view('admin.recommendations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon'        => ['required', 'string', 'max:10'],
            'color'       => ['required', 'string'],
            'risk_level'  => ['required', 'in:low,medium,high,all'],
            'category'    => ['nullable', 'string'],
            'tags'        => ['nullable', 'string'],
            'order'       => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['tags'] = $request->tags
            ? array_map('trim', explode(',', $request->tags))
            : [];

        Recommendation::create($validated);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Tavsiya muvaffaqiyatli qo\'shildi');
    }

    public function edit(Recommendation $recommendation)
    {
        return view('admin.recommendations.edit', compact('recommendation'));
    }

    public function update(Request $request, Recommendation $recommendation)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon'        => ['required', 'string', 'max:10'],
            'color'       => ['required', 'string'],
            'risk_level'  => ['required', 'in:low,medium,high,all'],
            'category'    => ['nullable', 'string'],
            'tags'        => ['nullable', 'string'],
            'order'       => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['tags'] = $request->tags
            ? array_map('trim', explode(',', $request->tags))
            : [];

        $recommendation->update($validated);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Tavsiya yangilandi');
    }

    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();
        return back()->with('success', 'Tavsiya o\'chirildi');
    }

    public function show(Recommendation $recommendation)
    {
        return view('admin.recommendations.show', compact('recommendation'));
    }
}