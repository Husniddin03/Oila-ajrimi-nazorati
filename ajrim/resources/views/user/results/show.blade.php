@extends('layouts.user')
@section('title', 'Natija — ' . $result->test->title)

@section('content')
    @php
        $foiz = round($result->score_average);
        $em = round($result->score_emotional);
        $fin = round($result->score_financial);
        $com = round($result->score_communication);
        $cls = fn($v) => $v >= 70 ? 'yaxshi' : ($v >= 40 ? 'orta' : 'yomon');
        $riskClass = $result->risk_level === 'high' ? 'yuqori' : ($result->risk_level === 'low' ? 'past' : 'orta');
    @endphp

    <div style="max-width:720px;margin:0 auto;">
        <!-- NAVIGATSIYA -->
        <div style="display:flex;gap:10px;margin-bottom:20px;">
            <a href="{{ route('user.results.index') }}" class="btn btn-ikkinchi">← Orqaga</a>
            <a href="{{ route('user.tests.start', $result->test) }}" class="btn btn-ikkinchi">🔄 Qayta topshirish</a>
        </div>

        <!-- NATIJA OYNA -->
        <div class="karta natija-oyna">
            <div class="natija-emoji">🎯</div>
            <div class="natija-nom">{{ $result->test->title }}</div>
            <div class="natija-tavsif">Test {{ $result->completed_at->format('d.m.Y') }} kuni muvaffaqiyatli yakunlandi</div>

            <!-- XAVF DARAJASI -->
            <div class="xavf-info {{ $riskClass }}" style="text-align:left;margin-bottom:20px;">
                <span class="xi-icon">{{ $result->risk_emoji }}</span>
                <div>
                    <div class="xi-nom">{{ $result->risk_label }} aniqlandi — {{ $foiz }}%</div>
                    <div class="xi-txt">Natijalaringiz tahlil qilindi. Quyida batafsil ko'rsatkichlar va tavsiyalar
                        keltirilgan.</div>
                </div>
            </div>

            <!-- KO'RSATKICHLAR -->
            <div class="korsatkichlar">
                <div class="k-karta">
                    <div class="k-doira {{ $cls($em) }}">{{ $em }}%</div>
                    <div class="k-nom">Emotsional</div>
                </div>
                <div class="k-karta">
                    <div class="k-doira {{ $cls($fin) }}">{{ $fin }}%</div>
                    <div class="k-nom">Moliyaviy</div>
                </div>
                <div class="k-karta">
                    <div class="k-doira {{ $cls($com) }}">{{ $com }}%</div>
                    <div class="k-nom">Muloqot</div>
                </div>
            </div>

            <div class="natija-btnlar">
                <a href="{{ route('user.tests.index') }}" class="btn btn-ikkinchi">← Testlarga qaytish</a>
            </div>
        </div>

        <!-- TAVSIYALAR -->
        @if ($recommendations->count())
            <div style="margin-top:24px;">
                <div class="section-sarlavha">
                    <h2>💡 Tavsiyalar</h2>
                </div>
                @foreach ($recommendations as $rec)
                    <div class="tav-karta">
                        <div class="tav-icon {{ $rec->color }}">{{ $rec->icon }}</div>
                        <div>
                            <div class="tav-nom">{{ $rec->title }}</div>
                            <div class="tav-txt">{{ $rec->description }}</div>
                            @if ($rec->tags)
                                <div class="tav-taglar">
                                    @foreach ($rec->tags as $tag)
                                        <span class="tav-tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
