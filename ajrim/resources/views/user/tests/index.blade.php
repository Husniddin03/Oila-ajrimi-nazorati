@extends('layouts.user')
@section('title', 'Testlar')

@section('content')
    <div class="section-sarlavha">
        <h2>📋 Barcha testlar</h2>
        <div style="font-size:.82rem;color:var(--matn2);">{{ $tests->count() }} ta test mavjud</div>
    </div>

    <div class="grid-3">
        @foreach ($tests as $test)
            <div class="test-karta">
                <div class="test-bant" style="background:{{ $test->color }};"></div>
                <div class="test-emoji">{{ $test->emoji }}</div>
                <div class="test-nom">{{ $test->title }}</div>
                <div class="test-tavsif">{{ $test->description }}</div>
                <div class="test-meta">
                    <div class="test-meta-el">❓ {{ $test->questions_count }} savol</div>
                    <div class="test-meta-el">⏱️ {{ $test->duration_minutes }} daqiqa</div>
                </div>

                @if ($test->user_completed > 0)
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('user.tests.start', $test) }}" class="btn btn-ikkinchi" style="flex:1;">🔄 Qayta
                            topshirish</a>
                        <a href="{{ route('user.results.index') }}" class="btn btn-asosiy" style="flex:1;">📊 Natijalar</a>
                    </div>
                @else
                    <a href="{{ route('user.tests.start', $test) }}" class="btn btn-asosiy"
                        style="width:100%;justify-content:center;">▶ Boshlash</a>
                @endif
            </div>
        @endforeach
    </div>
@endsection
