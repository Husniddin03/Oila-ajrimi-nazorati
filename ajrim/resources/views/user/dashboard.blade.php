@extends('layouts.user')
@section('title', 'Bosh sahifa')
@section('page-title', 'Bosh sahifa')

@section('content')
    <!-- STATISTIKA -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">📋</div>
            <div class="text-2xl font-bold text-matn mb-1">{{ $stats['completed_tests'] }}</div>
            <div class="text-sm text-matn2">Bajarilgan testlar</div>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">📝</div>
            <div class="text-2xl font-bold text-matn mb-1">{{ $stats['total_tests'] }}</div>
            <div class="text-sm text-matn2">Jami testlar</div>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">🎯</div>
            <div class="text-2xl font-bold text-matn mb-1">{{ $stats['total_tests'] - $stats['completed_tests'] }}</div>
            <div class="text-sm text-matn2">Qolgan testlar</div>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">📈</div>
            @php $latest = $stats['latest_result']; @endphp
            <div class="text-2xl font-bold {{
                $latest ? ($latest->risk_level === 'high' ? 'text-aksent' : ($latest->risk_level === 'low' ? 'text-yashil' : 'text-sariq')) : 'text-matn2'
            }} mb-1">
                {{ $latest ? round($latest->score_average) . '%' : '—' }}
            </div>
            <div class="text-sm text-matn2">So'nggi natija</div>
        </div>
    </div>

    <!-- SO'NGGI NATIJA BANNER -->
    @if ($latest)
        <div class="bg-karta border border-chegara rounded-xl p-5 mb-6 {{
            $latest->risk_level === 'high' ? 'border-red-500/30 bg-red-500/5' : 
            ($latest->risk_level === 'low' ? 'border-green-500/30 bg-green-500/5' : 
            'border-yellow-500/30 bg-yellow-500/5')
        }}">
            <div class="flex items-center gap-4">
                <span class="text-3xl">{{ $latest->risk_emoji }}</span>
                <div class="flex-1">
                    <div class="font-medium text-matn mb-1">{{ $latest->risk_label }} aniqlandi — {{ round($latest->score_average) }}%</div>
                    <div class="text-sm text-matn2">Test: {{ $latest->test->title }} • {{ $latest->completed_at->format('d.m.Y') }}</div>
                </div>
                <a href="{{ route('user.results.show', $latest) }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200 flex-shrink-0">Batafsil →</a>
            </div>
        </div>

        <!-- KO'RSATKICHLAR -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            @php
                $em = round($latest->score_emotional);
                $fin = round($latest->score_financial);
                $com = round($latest->score_communication);
                $getClass = fn($v) => $v >= 70 ? 'bg-green-500/20 text-green-400 border-green-500/30' : ($v >= 40 ? 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30' : 'bg-red-500/20 text-red-400 border-red-500/30');
            @endphp
            <div class="bg-karta border border-chegara rounded-xl p-4 text-center hover:border-aksent/50 transition-all duration-200">
                <div class="w-16 h-16 mx-auto mb-2 rounded-full border-2 {{ $getClass($em) }} flex items-center justify-center font-bold text-lg">{{ $em }}%</div>
                <div class="text-sm text-matn2">Emotsional</div>
            </div>
            <div class="bg-karta border border-chegara rounded-xl p-4 text-center hover:border-aksent/50 transition-all duration-200">
                <div class="w-16 h-16 mx-auto mb-2 rounded-full border-2 {{ $getClass($fin) }} flex items-center justify-center font-bold text-lg">{{ $fin }}%</div>
                <div class="text-sm text-matn2">Moliyaviy</div>
            </div>
            <div class="bg-karta border border-chegara rounded-xl p-4 text-center hover:border-aksent/50 transition-all duration-200">
                <div class="w-16 h-16 mx-auto mb-2 rounded-full border-2 {{ $getClass($com) }} flex items-center justify-center font-bold text-lg">{{ $com }}%</div>
                <div class="text-sm text-matn2">Muloqot</div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- MAVJUD TESTLAR -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-matn flex items-center gap-2">📋 Testlar</h2>
                <a href="{{ route('user.tests.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-3 py-1.5 rounded-lg text-sm transition-all duration-200">Barchasi</a>
            </div>
            <div class="space-y-3">
                @forelse($availableTests->take(4) as $test)
                    <div class="bg-karta border border-chegara rounded-xl overflow-hidden hover:border-aksent/50 transition-all duration-200">
                        <div class="h-1" style="background:{{ $test->color }};"></div>
                        <div class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="text-2xl">{{ $test->emoji }}</div>
                                <div class="flex-1">
                                    <div class="font-medium text-matn mb-1">{{ $test->title }}</div>
                                    <div class="text-xs text-matn2">❓ {{ $test->questions_count }} savol</div>
                                </div>
                                @if ($test->user_completed > 0)
                                    <span class="inline-flex items-center px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">✅ Bajarildi</span>
                                @else
                                    <a href="{{ route('user.tests.start', $test) }}" class="bg-aksent hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm transition-all duration-200">Boshlash</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-karta border border-chegara rounded-xl p-8 text-center text-matn2">Testlar mavjud emas</div>
                @endforelse
            </div>
        </div>

        <!-- SO'NGGI NATIJALAR -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-matn flex items-center gap-2">📈 So'nggi natijalar</h2>
                <a href="{{ route('user.results.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-3 py-1.5 rounded-lg text-sm transition-all duration-200">Barchasi</a>
            </div>
            @forelse($recentResults as $result)
                <a href="{{ route('user.results.show', $result) }}" class="block bg-karta border border-chegara rounded-xl p-4 mb-3 hover:border-aksent/50 transition-all duration-200 text-decoration-none">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl">{{ $result->test->emoji ?? '📋' }}</div>
                        <div class="flex-1">
                            <div class="font-medium text-matn mb-1">{{ $result->test->title }}</div>
                            <div class="text-sm text-matn2">{{ $result->completed_at->format('d.m.Y') }}</div>
                        </div>
                        <div class="text-right">
                            @php $foiz = round($result->score_average); @endphp
                            <div class="text-lg font-bold {{
                                $foiz >= 70 ? 'text-yashil' : ($foiz >= 40 ? 'text-sariq' : 'text-aksent')
                            }}">{{ $foiz }}%</div>
                            <div class="text-xs text-matn2">{{ $result->risk_label }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-karta border border-chegara rounded-xl p-10 text-center">
                    <div class="text-4xl mb-3">📊</div>
                    <div class="text-matn2 mb-4">Hali test topshirilmagan</div>
                    <a href="{{ route('user.tests.index') }}" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200">Testlarga o'tish</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
