@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- STAT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">👥</div>
            <div class="text-2xl font-bold text-matn mb-1">{{ $stats['total_users'] }}</div>
            <div class="text-sm text-matn2 mb-2">Jami foydalanuvchilar</div>
            <div class="text-xs text-yashil">● {{ $stats['active_users'] }} faol</div>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">📋</div>
            <div class="text-2xl font-bold text-matn mb-1">{{ $stats['total_tests'] }}</div>
            <div class="text-sm text-matn2">Jami testlar</div>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">📊</div>
            <div class="text-2xl font-bold text-matn mb-1">{{ $stats['total_results'] }}</div>
            <div class="text-sm text-matn2">Topshirilgan testlar</div>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6 hover:border-aksent/50 transition-all duration-200">
            <div class="text-3xl mb-3">🔴</div>
            <div class="text-2xl font-bold text-aksent mb-1">{{ $stats['high_risk'] }}</div>
            <div class="text-sm text-matn2 mb-2">Yuqori xavf</div>
            <div class="text-xs text-sariq">⚠️ E'tibor talab qiladi</div>
        </div>
    </div>

    <!-- XAVF DARAJALARI -->
    <div class="bg-karta border border-chegara rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="font-playfair text-lg text-matn">Xavf darajalari taqsimoti</div>
        </div>
        @php
            $jami = $stats['total_results'] ?: 1;
            $yuqori_foiz = round(($stats['high_risk'] / $jami) * 100);
            $orta_foiz = round(($stats['medium_risk'] / $jami) * 100);
            $past_foiz = round(($stats['low_risk'] / $jami) * 100);
        @endphp
        <div class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-[180px]">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-aksent">🔴 Yuqori xavf</span>
                    <span>{{ $stats['high_risk'] }} ({{ $yuqori_foiz }}%)</span>
                </div>
                <div class="w-full bg-fon3 h-2.5 rounded-full overflow-hidden">
                    <div class="h-full bg-aksent transition-all duration-500" style="width: {{ $yuqori_foiz }}%"></div>
                </div>
            </div>
            <div class="flex-1 min-w-[180px]">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-sariq">🟡 O'rta xavf</span>
                    <span>{{ $stats['medium_risk'] }} ({{ $orta_foiz }}%)</span>
                </div>
                <div class="w-full bg-fon3 h-2.5 rounded-full overflow-hidden">
                    <div class="h-full bg-sariq transition-all duration-500" style="width: {{ $orta_foiz }}%"></div>
                </div>
            </div>
            <div class="flex-1 min-w-[180px]">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-yashil">🟢 Past xavf</span>
                    <span>{{ $stats['low_risk'] }} ({{ $past_foiz }}%)</span>
                </div>
                <div class="w-full bg-fon3 h-2.5 rounded-full overflow-hidden">
                    <div class="h-full bg-yashil transition-all duration-500" style="width: {{ $past_foiz }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- SO'NGGI NATIJALAR -->
        <div class="bg-karta border border-chegara rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="font-playfair text-lg text-matn">So'nggi natijalar</div>
                <a href="{{ route('admin.results.index') }}" class="bg-fon3 hover:bg-fon2 text-matn2 hover:text-matn px-3 py-1.5 rounded-lg text-sm transition-all duration-200">Barchasi</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-chegara">
                            <th class="text-left py-2 px-2 text-xs font-medium text-matn2">Foydalanuvchi</th>
                            <th class="text-left py-2 px-2 text-xs font-medium text-matn2">Test</th>
                            <th class="text-left py-2 px-2 text-xs font-medium text-matn2">Natija</th>
                            <th class="text-left py-2 px-2 text-xs font-medium text-matn2">Xavf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentResults as $result)
                            <tr class="border-b border-chegara/30 hover:bg-fon3/50 transition-colors">
                                <td class="py-3 px-2 text-sm text-matn">{{ $result->user->name }}</td>
                                <td class="py-3 px-2 text-sm text-matn2">{{ Str::limit($result->test->title, 20) }}</td>
                                <td class="py-3 px-2 text-sm text-matn">{{ round($result->score_average) }}%</td>
                                <td class="py-3 px-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                        $result->risk_level === 'high' ? 'bg-red-500/20 text-red-400' : 
                                        ($result->risk_level === 'low' ? 'bg-green-500/20 text-green-400' : 
                                        'bg-yellow-500/20 text-yellow-400')
                                    }}">
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
        <div class="bg-karta border border-chegara rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="font-playfair text-lg text-matn">Yangi foydalanuvchilar</div>
                <a href="{{ route('admin.users.index') }}" class="bg-fon3 hover:bg-fon2 text-matn2 hover:text-matn px-3 py-1.5 rounded-lg text-sm transition-all duration-200">Barchasi</a>
            </div>
            @foreach ($recentUsers as $user)
                <div class="flex items-center gap-3 py-2.5 border-b border-chegara/30 last:border-0 hover:bg-fon3/30 transition-colors rounded-lg px-2">
                    <div class="w-8.5 h-8.5 rounded-full bg-gradient-to-br from-aksent to-red-800 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                        {{ $user->initials }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm text-matn truncate">{{ $user->name }}</div>
                        <div class="text-xs text-matn2 truncate">{{ $user->email }}</div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                        $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
                    }}">
                        {{ $user->status === 'active' ? 'Faol' : 'Bloklangan' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
