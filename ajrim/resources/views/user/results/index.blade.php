@extends('layouts.user')
@section('title', 'Natijalar')

@section('content')
    <div class="section-sarlavha">
        <h2>📈 Mening natijalarim</h2>
        <div style="font-size:.82rem;color:var(--matn2);">{{ $results->total() }} ta natija</div>
    </div>

    @if ($results->isEmpty())
        <div class="karta" style="text-align:center;padding:60px;">
            <div style="font-size:3rem;margin-bottom:16px;">📊</div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;margin-bottom:8px;">Hali natija yo'q</div>
            <div style="color:var(--matn2);font-size:.875rem;margin-bottom:20px;">Birinchi testni boshlash uchun tugmani
                bosing</div>
            <a href="{{ route('user.tests.index') }}" class="btn btn-asosiy">▶ Testlarga o'tish</a>
        </div>
    @else
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach ($results as $result)
                @php $foiz = round($result->score_average); @endphp
                <a href="{{ route('user.results.show', $result) }}" class="tarix-el" style="text-decoration:none;">
                    <div class="tarix-icon">{{ $result->test->emoji ?? '📋' }}</div>
                    <div class="tarix-info">
                        <div class="tarix-nom">{{ $result->test->title }}</div>
                        <div class="tarix-sana">📅 {{ $result->completed_at->format('d.m.Y H:i') }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="ts-foiz {{ $foiz >= 70 ? 'yaxshi' : ($foiz >= 40 ? 'orta' : 'yomon') }}">
                            {{ $foiz }}%</div>
                        <div class="ts-daraja">{{ $result->risk_label }}</div>
                    </div>
                </a>
            @endforeach
        </div>
        {{ $results->links() }}
    @endif
@endsection
