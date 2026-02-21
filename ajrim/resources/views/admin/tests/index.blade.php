@extends('layouts.admin')
@section('title', 'Testlar')
@section('page-title', 'Testlar')

@section('content')
    <div class="section-sarlavha">
        <h2>📋 Testlar</h2>
        <a href="{{ route('admin.tests.create') }}" class="btn btn-asosiy">+ Yangi test</a>
    </div>

    <div class="grid-3">
        @forelse($tests as $test)
            <div class="karta" style="position:relative;overflow:hidden;">
                <div
                    style="height:4px;position:absolute;top:0;left:0;right:0;background:{{ $test->color }};border-radius:12px 12px 0 0;">
                </div>
                <div style="margin-top:8px;display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
                    <div style="font-size:2rem;">{{ $test->emoji }}</div>
                    <div style="display:flex;gap:5px;flex-wrap:wrap;">
                        <span class="chip {{ $test->is_active ? 'chip-yashil' : 'chip-qizil' }}">
                            {{ $test->is_active ? '● Faol' : '● O\'chirilgan' }}
                        </span>
                    </div>
                </div>
                <div style="font-family:'Playfair Display',serif;font-size:1rem;margin:10px 0 6px;">{{ $test->title }}
                </div>
                <div style="font-size:.78rem;color:var(--matn2);margin-bottom:12px;line-height:1.5;">
                    {{ Str::limit($test->description, 80) }}</div>
                <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;">
                    <span class="chip chip-moviy">❓ {{ $test->questions_count }} savol</span>
                    <span class="chip chip-sariq">✅ {{ $test->results_count }} marta</span>
                </div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <a href="{{ route('admin.tests.questions.index', $test) }}" class="btn btn-yashil btn-sm">❓ Savollar</a>
                    <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-ikkinchi btn-sm">✏️</a>
                    <form action="{{ route('admin.tests.toggle-active', $test) }}" method="POST" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $test->is_active ? 'btn-xavf' : 'btn-yashil' }}">
                            {{ $test->is_active ? '🔴 O\'chir' : '🟢 Yoq' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.tests.destroy', $test) }}" method="POST" style="display:inline;"
                        onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xavf btn-sm">🗑️</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="karta" style="grid-column:1/-1;text-align:center;padding:60px;color:var(--matn2);">
                <div style="font-size:3rem;margin-bottom:12px;">📋</div>
                Testlar mavjud emas. <a href="{{ route('admin.tests.create') }}" style="color:var(--aksent);">Yangi test
                    yarating</a>
            </div>
        @endforelse
    </div>
@endsection
