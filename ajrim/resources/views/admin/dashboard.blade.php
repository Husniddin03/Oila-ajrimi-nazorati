@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- STAT GRID -->
    <div class="grid-4" style="margin-bottom:24px;">
        <div class="stat-quti">
            <div class="stat-icon">👥</div>
            <div class="stat-son">{{ $stats['total_users'] }}</div>
            <div class="stat-nom">Jami foydalanuvchilar</div>
            <div class="stat-trend up">● {{ $stats['active_users'] }} faol</div>
        </div>
        <div class="stat-quti">
            <div class="stat-icon">📋</div>
            <div class="stat-son">{{ $stats['total_tests'] }}</div>
            <div class="stat-nom">Jami testlar</div>
        </div>
        <div class="stat-quti">
            <div class="stat-icon">📊</div>
            <div class="stat-son">{{ $stats['total_results'] }}</div>
            <div class="stat-nom">Topshirilgan testlar</div>
        </div>
        <div class="stat-quti">
            <div class="stat-icon">🔴</div>
            <div class="stat-son" style="color:#e94560;">{{ $stats['high_risk'] }}</div>
            <div class="stat-nom">Yuqori xavf</div>
            <div class="stat-trend down">⚠️ E'tibor talab qiladi</div>
        </div>
    </div>

    <!-- XAVF DARAJALARI -->
    <div class="karta" style="margin-bottom:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div style="font-family:'Playfair Display',serif;font-size:1.1rem;">Xavf darajalari taqsimoti</div>
        </div>
        @php
            $jami = $stats['total_results'] ?: 1;
            $yuqori_foiz = round(($stats['high_risk'] / $jami) * 100);
            $orta_foiz = round(($stats['medium_risk'] / $jami) * 100);
            $past_foiz = round(($stats['low_risk'] / $jami) * 100);
        @endphp
        <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <div style="flex:1;min-width:180px;">
                <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:5px;">
                    <span style="color:#e94560;">🔴 Yuqori xavf</span>
                    <span>{{ $stats['high_risk'] }} ({{ $yuqori_foiz }}%)</span>
                </div>
                <div class="progress-bar" style="background:#21262d;height:10px;">
                    <div class="progress-fill" style="width:{{ $yuqori_foiz }}%;background:#e94560;"></div>
                </div>
            </div>
            <div style="flex:1;min-width:180px;">
                <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:5px;">
                    <span style="color:#d29922;">🟡 O'rta xavf</span>
                    <span>{{ $stats['medium_risk'] }} ({{ $orta_foiz }}%)</span>
                </div>
                <div class="progress-bar" style="background:#21262d;height:10px;">
                    <div class="progress-fill" style="width:{{ $orta_foiz }}%;background:#d29922;"></div>
                </div>
            </div>
            <div style="flex:1;min-width:180px;">
                <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:5px;">
                    <span style="color:#3fb950;">🟢 Past xavf</span>
                    <span>{{ $stats['low_risk'] }} ({{ $past_foiz }}%)</span>
                </div>
                <div class="progress-bar" style="background:#21262d;height:10px;">
                    <div class="progress-fill" style="width:{{ $past_foiz }}%;background:#3fb950;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-2" style="gap:20px;">
        <!-- SO'NGGI NATIJALAR -->
        <div class="karta">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div style="font-family:'Playfair Display',serif;font-size:1.1rem;">So'nggi natijalar</div>
                <a href="{{ route('admin.results.index') }}" class="btn btn-ikkinchi btn-sm">Barchasi</a>
            </div>
            <div class="jadval-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Foydalanuvchi</th>
                            <th>Test</th>
                            <th>Natija</th>
                            <th>Xavf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentResults as $result)
                            <tr>
                                <td>{{ $result->user->name }}</td>
                                <td style="color:var(--matn2);">{{ Str::limit($result->test->title, 20) }}</td>
                                <td>{{ round($result->score_average) }}%</td>
                                <td>
                                    <span
                                        class="chip {{ $result->risk_level === 'high' ? 'chip-qizil' : ($result->risk_level === 'low' ? 'chip-yashil' : 'chip-sariq') }}">
                                        {{ $result->risk_label }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- YANGI FOYDALANUVCHILAR -->
        <div class="karta">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div style="font-family:'Playfair Display',serif;font-size:1.1rem;">Yangi foydalanuvchilar</div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-ikkinchi btn-sm">Barchasi</a>
            </div>
            @foreach ($recentUsers as $user)
                <div
                    style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid rgba(48,54,61,.5);">
                    <div
                        style="width:34px;height:34px;border-radius:50%;background:var(--aksent);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;flex-shrink:0;">
                        {{ $user->initials }}
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:.875rem;">{{ $user->name }}</div>
                        <div style="font-size:.72rem;color:var(--matn2);">{{ $user->email }}</div>
                    </div>
                    <span class="chip {{ $user->status === 'active' ? 'chip-yashil' : 'chip-qizil' }}">
                        {{ $user->status === 'active' ? 'Faol' : 'Bloklangan' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
