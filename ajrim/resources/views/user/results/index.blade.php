@extends('layouts.user')
@section('title', 'Natijalar')
@section('page-title', 'Natijalar')

@section('content')
    @if ($results->isEmpty())
        <div class="bg-karta border border-chegara rounded-xl p-16 text-center">
            <div class="text-5xl mb-4">📊</div>
            <div class="font-playfair text-2xl font-semibold text-matn mb-2">Hali natija yo'q</div>
            <div class="text-matn2 mb-5">Birinchi testni boshlash uchun tugmani bosing</div>
            <a href="{{ route('user.tests.index') }}" class="bg-aksent hover:bg-red-600 text-white px-6 py-3 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">▶ Testlarga o'tish</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($results as $result)
                @php $foiz = round($result->score_average); @endphp
                <a href="{{ route('user.results.show', $result) }}" class="block bg-karta border border-chegara rounded-xl p-4 hover:border-aksent/50 transition-all duration-200 text-decoration-none">
                    <div class="flex items-center gap-4">
                        <div class="text-3xl">{{ $result->test->emoji ?? '📋' }}</div>
                        <div class="flex-1">
                            <div class="font-medium text-matn mb-1">{{ $result->test->title }}</div>
                            <div class="text-sm text-matn2">📅 {{ $result->completed_at->format('d.m.Y H:i') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold {{
                                $foiz >= 70 ? 'text-yashil' : ($foiz >= 40 ? 'text-sariq' : 'text-aksent')
                            }}">{{ $foiz }}%</div>
                            <div class="text-xs text-matn2">{{ $result->risk_label }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $results->links() }}
        </div>
    @endif
@endsection
