@extends('layouts.user')
@section('title', 'Testlar')
@section('page-title', 'Testlar')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($tests as $test)
            <div class="bg-karta border border-chegara rounded-xl overflow-hidden hover:border-aksent/50 transition-all duration-200">
                <div class="h-2" style="background:{{ $test->color }};"></div>
                <div class="p-5">
                    <div class="text-3xl mb-3 text-center">{{ $test->emoji }}</div>
                    <h3 class="font-playfair text-lg text-matn mb-2 text-center">{{ $test->title }}</h3>
                    <p class="text-sm text-matn2 mb-4 text-center leading-relaxed">{{ $test->description }}</p>
                    <div class="flex justify-center gap-4 mb-4 text-xs text-matn2">
                        <div class="flex items-center gap-1">
                            <span>❓</span>
                            <span>{{ $test->questions_count }} savol</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>⏱️</span>
                            <span>{{ $test->duration_minutes }} daqiqa</span>
                        </div>
                    </div>

                    @if ($test->user_completed > 0)
                        <div class="flex gap-2">
                            <a href="{{ route('user.tests.start', $test) }}" class="flex-1 bg-fon3 hover:bg-fon2 text-matn px-3 py-2 rounded-lg text-sm transition-all duration-200 text-center">🔄 Qayta topshirish</a>
                            <a href="{{ route('user.results.index') }}" class="flex-1 bg-aksent hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition-all duration-200 text-center">📊 Natijalar</a>
                        </div>
                    @else
                        <a href="{{ route('user.tests.start', $test) }}" class="w-full bg-aksent hover:bg-red-600 text-white px-4 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 text-center flex items-center justify-center gap-2">▶ Boshlash</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
