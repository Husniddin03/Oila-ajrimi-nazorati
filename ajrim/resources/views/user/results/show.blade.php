@extends('layouts.user')
@section('title', 'Natija — ' . $result->test->title)
@section('page-title', 'Test natijasi')

@section('content')
    @php
        $foiz = round($result->score_average);
        $em = round($result->score_emotional);
        $fin = round($result->score_financial);
        $com = round($result->score_communication);
        $cls = fn($v) => $v >= 70 ? 'bg-green-500/20 text-green-400 border-green-500/30' : ($v >= 40 ? 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30' : 'bg-red-500/20 text-red-400 border-red-500/30');
        $riskClass = $result->risk_level === 'high' ? 'border-red-500/30 bg-red-500/5' : ($result->risk_level === 'low' ? 'border-green-500/30 bg-green-500/5' : 'border-yellow-500/30 bg-yellow-500/5');
    @endphp

    <div class="max-w-4xl mx-auto">
        <!-- NATIJA OYNA -->
        <div class="bg-karta border border-chegara rounded-xl overflow-hidden mb-6">
            <div class="text-center py-8">
                <div class="text-5xl mb-4">🎯</div>
                <h3 class="font-playfair text-2xl font-semibold text-matn mb-2">{{ $result->test->title }}</h3>
                <p class="text-matn2">Test {{ $result->completed_at->format('d.m.Y') }} kuni muvaffaqiyatli yakunlandi</p>
            </div>

            <!-- XAVF DARAJASI -->
            <div class="{{ $riskClass }} p-5 text-left">
                <div class="flex items-start gap-4">
                    <span class="text-3xl">{{ $result->risk_emoji }}</span>
                    <div class="flex-1">
                        <div class="font-medium text-matn mb-1">{{ $result->risk_label }} aniqlandi — {{ $foiz }}%</div>
                        <div class="text-sm text-matn2">Natijalaringiz tahlil qilindi. Quyida batafsil ko'rsatkichlar va tavsiyalar keltirilgan.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KO'RSATKICHLAR -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-karta border border-chegara rounded-xl p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-2 rounded-full border-2 {{ $cls($em) }} flex items-center justify-center font-bold text-lg">{{ $em }}%</div>
                <div class="text-sm text-matn2">Emotsional</div>
            </div>
            <div class="bg-karta border border-chegara rounded-xl p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-2 rounded-full border-2 {{ $cls($fin) }} flex items-center justify-center font-bold text-lg">{{ $fin }}%</div>
                <div class="text-sm text-matn2">Moliyaviy</div>
            </div>
            <div class="bg-karta border border-chegara rounded-xl p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-2 rounded-full border-2 {{ $cls($com) }} flex items-center justify-center font-bold text-lg">{{ $com }}%</div>
                <div class="text-sm text-matn2">Muloqot</div>
            </div>
        </div>

        <div class="text-center mb-6">
            <a href="{{ route('user.tests.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-6 py-3 rounded-lg transition-all duration-200">← Testlarga qaytish</a>
        </div>
    </div>

    <!-- TAVSIYALAR -->
    @if ($recommendations->count())
        <div class="mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($recommendations as $rec)
                    <div class="bg-karta border border-chegara rounded-xl p-5 hover:border-aksent/50 transition-all duration-200">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="text-2xl p-2 rounded-lg bg-{{ $rec->color ?? 'yashil' }}/10 text-{{ $rec->color ?? 'yashil' }}">{{ $rec->icon }}</div>
                            <div class="flex-1">
                                <h4 class="font-medium text-matn mb-2">{{ $rec->title }}</h4>
                                <p class="text-sm text-matn2 leading-relaxed">{{ $rec->description }}</p>
                                @if ($rec->tags)
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach ($rec->tags as $tag)
                                            <span class="inline-flex items-center px-2 py-1 bg-fon3 text-matn2 rounded text-xs">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
