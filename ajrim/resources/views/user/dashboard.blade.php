@extends('layouts.user')
@section('title', 'Bosh sahifa')

@section('content')
    <div class="section-sarlavha">
        <h2>📊 Umumiy ko'rsatkichlar</h2>
        <div style="font-size:.82rem;color:var(--matn2);">Xush kelibsiz!</div>
    </div>

    <!-- STATISTIKA -->
    <div class="grid-4" style="margin-bottom:24px;">
        <div class="stat-quti">
            <div class="stat-icon">📋</div>
            <div class="stat-son">{{ $stats['completed_tests'] }}</div>
            <div class="stat-nom">Bajarilgan testlar</div>
        </div>
        <div class="stat-quti">
            <div class="stat-icon">📝</div>
            <div class="stat-son">{{ $stats['total_tests'] }}</div>
            <div class="stat-nom">Jami testlar</div>
        </div>
        <div class="stat-quti">
            <div class="stat-icon">🎯</div>
            <div class="stat-son">{{ $stats['total_tests'] - $stats['completed_tests'] }}</div>
            <div class="stat-nom">Qolgan testlar</div>
        </div>
        <div class="stat-quti">
            <div class="stat-icon">📈</div>
            @php $latest = $stats['latest_result']; @endphp
            <div class="stat-son"
                style="color:{{ $latest ? ($latest->risk_level === 'high' ? '#e94560' : ($latest->risk_level === 'low' ? '#3fb950' : '#d29922')) : 'var(--matn2)' }}">
                {{ $latest ? round($latest->score_average) . '%' : '—' }}
            </div>
            <div class="stat-nom">So'nggi natija</div>
        </div>
    </div>

    <!-- SO'NGGI NATIJA BANNER -->
    @if ($latest)
        <div class="xavf-info {{ $latest->risk_level === 'high' ? 'yuqori' : ($latest->risk_level === 'low' ? 'past' : 'orta') }}"
            style="margin-bottom:24px;">
            <span class="xi-icon">{{ $latest->risk_emoji }}</span>
            <div>
                <div class="xi-nom">{{ $latest->risk_label }} aniqlandi — {{ round($latest->score_average) }}%</div>
                <div class="xi-txt">Test: {{ $latest->test->title }} • {{ $latest->completed_at->format('d.m.Y') }}</div>
            </div>
            <a href="{{ route('user.results.show', $latest) }}" class="btn btn-ikkinchi"
                style="margin-left:auto;flex-shrink:0;">Batafsil →</a>
        </div>

        <!-- KO'RSATKICHLAR -->
        <div class="korsatkichlar" style="margin-bottom:24px;">
            @php
                $em = round($latest->score_emotional);
                $fin = round($latest->score_financial);
                $com = round($latest->score_communication);
                $getClass = fn($v) => $v >= 70 ? 'yaxshi' : ($v >= 40 ? 'orta' : 'yomon');
            @endphp
            <div class="k-karta">
                <div class="k-doira {{ $getClass($em) }}">{{ $em }}%</div>
                <div class="k-nom">Emotsional</div>
            </div>
            <div class="k-karta">
                <div class="k-doira {{ $getClass($fin) }}">{{ $fin }}%</div>
                <div class="k-nom">Moliyaviy</div>
            </div>
            <div class="k-karta">
                <div class="k-doira {{ $getClass($com) }}">{{ $com }}%</div>
                <div class="k-nom">Muloqot</div>
            </div>
        </div>
    @endif

    <div class="grid-2" style="gap:24px;">
        <!-- MAVJUD TESTLAR -->
        <div>
            <div class="section-sarlavha">
                <h2>📋 Testlar</h2>
                <a href="{{ route('user.tests.index') }}" class="btn btn-ikkinchi"
                    style="font-size:.78rem;padding:7px 12px;">Barchasi</a>
            </div>
            <div style="display:grid;gap:12px;">
                @forelse($availableTests->take(4) as $test)
                    <div class="test-karta" style="padding:16px;">
                        <div class="test-bant" style="background:{{ $test->color }};"></div>
                        <div style="display:flex;align-items:center;gap:12px;margin-top:6px;">
                            <div style="font-size:1.6rem;">{{ $test->emoji }}</div>
                            <div style="flex:1;">
                                <div class="test-nom" style="font-size:.95rem;">{{ $test->title }}</div>
                                <div style="font-size:.75rem;color:var(--matn2);">❓ {{ $test->questions_count }} savol
                                </div>
                            </div>
                            @if ($test->user_completed > 0)
                                <span class="xavf-badge past">✅ Bajarildi</span>
                            @else
                                <a href="{{ route('user.tests.start', $test) }}" class="btn btn-asosiy"
                                    style="font-size:.78rem;padding:7px 12px;">Boshlash</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:30px;color:var(--matn2);">Testlar mavjud emas</div>
                @endforelse
            </div>
        </div>

        <!-- SO'NGGI NATIJALAR -->
        <div>
            <div class="section-sarlavha">
                <h2>📈 So'nggi natijalar</h2>
                <a href="{{ route('user.results.index') }}" class="btn btn-ikkinchi"
                    style="font-size:.78rem;padding:7px 12px;">Barchasi</a>
            </div>
            @forelse($recentResults as $result)
                <a href="{{ route('user.results.show', $result) }}" class="tarix-el" style="text-decoration:none;">
                    <div class="tarix-icon">{{ $result->test->emoji ?? '📋' }}</div>
                    <div class="tarix-info">
                        <div class="tarix-nom">{{ $result->test->title }}</div>
                        <div class="tarix-sana">{{ $result->completed_at->format('d.m.Y') }}</div>
                    </div>
                    <div>
                        @php $foiz = round($result->score_average); @endphp
                        <div class="ts-foiz {{ $foiz >= 70 ? 'yaxshi' : ($foiz >= 40 ? 'orta' : 'yomon') }}">
                            {{ $foiz }}%</div>
                        <div class="ts-daraja">{{ $result->risk_label }}</div>
                    </div>
                </a>
            @empty
                <div class="karta" style="text-align:center;padding:40px;color:var(--matn2);">
                    <div style="font-size:2.5rem;margin-bottom:12px;">📊</div>
                    <div>Hali test topshirilmagan</div>
                    <a href="{{ route('user.tests.index') }}" class="btn btn-asosiy" style="margin-top:12px;">Testlarga
                        o'tish</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
