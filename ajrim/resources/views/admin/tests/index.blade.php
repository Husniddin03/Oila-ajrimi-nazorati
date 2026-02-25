@extends('layouts.admin')
@section('title', 'Testlar')
@section('page-title', 'Testlar')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-matn flex items-center gap-2">📋 Testlar</h2>
        <a href="{{ route('admin.tests.create') }}" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">+ Yangi test</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tests as $test)
            <div class="bg-karta border border-chegara rounded-xl overflow-hidden hover:border-aksent/50 transition-all duration-200">
                <div class="h-1 bg-gradient-to-r from-{{ $test->color }} to-{{ $test->color }}/80"></div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="text-3xl">{{ $test->emoji }}</div>
                        <div class="flex gap-2 flex-wrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                $test->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
                            }}">
                                {{ $test->is_active ? '● Faol' : '● O\'chirilgan' }}
                            </span>
                        </div>
                    </div>
                    <h3 class="font-playfair text-lg text-matn mb-2">{{ $test->title }}</h3>
                    <p class="text-sm text-matn2 mb-4 line-clamp-3 leading-relaxed">
                        {{ Str::limit($test->description, 80) }}
                    </p>
                    <div class="flex gap-2 mb-4 flex-wrap">
                        <span class="inline-flex items-center px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-medium">❓ {{ $test->questions_count }} savol</span>
                        <span class="inline-flex items-center px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium">✅ {{ $test->results_count }} marta</span>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('admin.tests.questions.index', $test) }}" class="bg-green-500/20 hover:bg-green-500/30 text-green-400 px-3 py-1.5 rounded-lg text-sm transition-all duration-200">❓ Savollar</a>
                        <a href="{{ route('admin.tests.edit', $test) }}" class="bg-fon3 hover:bg-fon2 text-matn px-3 py-1.5 rounded-lg text-sm transition-all duration-200">✏️</a>
                        <form action="{{ route('admin.tests.toggle-active', $test) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="{{
                                $test->is_active 
                                ? 'bg-red-500/20 hover:bg-red-500/30 text-red-400' 
                                : 'bg-green-500/20 hover:bg-green-500/30 text-green-400'
                            }} px-3 py-1.5 rounded-lg text-sm transition-all duration-200">
                                {{ $test->is_active ? '🔴 O\'chir' : '🟢 Yoq' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.tests.destroy', $test) }}" method="POST" class="inline"
                            onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-1.5 rounded-lg text-sm transition-all duration-200">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-karta border border-chegara rounded-xl p-12 text-center col-span-full">
                <div class="text-5xl mb-3">📋</div>
                <p class="text-matn2 mb-4">Testlar mavjud emas.</p>
                <a href="{{ route('admin.tests.create') }}" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">Yangi test yarating</a>
            </div>
        @endforelse
    </div>
@endsection
