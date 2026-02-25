@extends('layouts.admin')
@section('title', 'Natijalar')
@section('page-title', 'Natijalar')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-matn flex items-center gap-2">📈 Test natijalari</h2>
        <div class="text-sm text-matn2">{{ $results->total() }} ta natija</div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="bg-karta border border-chegara rounded-xl p-4 mb-6">
        <div class="flex flex-wrap gap-3 items-end">
            <input type="text" name="search" class="flex-1 min-w-[200px] px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" placeholder="🔍 Foydalanuvchi nomi..." value="{{ request('search') }}">
            <select name="risk_level" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                <option value="">Barcha xavflar</option>
                <option value="high" {{ request('risk_level') === 'high' ? 'selected' : '' }}>🔴 Yuqori</option>
                <option value="medium" {{ request('risk_level') === 'medium' ? 'selected' : '' }}>🟡 O'rta</option>
                <option value="low" {{ request('risk_level') === 'low' ? 'selected' : '' }}>🟢 Past</option>
            </select>
            <select name="test_id" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                <option value="">Barcha testlar</option>
                @foreach ($allTests as $id => $title)
                    <option value="{{ $id }}" {{ request('test_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">Filtr</button>
            <a href="{{ route('admin.results.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">Tozalash</a>
        </div>
    </form>

    <div class="bg-karta border border-chegara rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-fon3 border-b border-chegara">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">#</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Foydalanuvchi</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Test</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Emotsional</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Moliyaviy</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Muloqot</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">O'rtacha</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Xavf</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Sana</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $i => $result)
                        <tr class="border-b border-chegara/30 hover:bg-fon3/50 transition-colors">
                            <td class="py-3 px-4 text-sm text-matn2">{{ $results->firstItem() + $i }}</td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-matn">{{ $result->user->name }}</div>
                                <div class="text-xs text-matn2">{{ $result->user->email }}</div>
                            </td>
                            <td class="py-3 px-4 text-sm text-matn2">{{ Str::limit($result->test->title, 25) }}</td>
                            <td class="py-3 px-4 text-sm text-moviy">{{ round($result->score_emotional) }}%</td>
                            <td class="py-3 px-4 text-sm text-sariq">{{ round($result->score_financial) }}%</td>
                            <td class="py-3 px-4 text-sm text-yashil">{{ round($result->score_communication) }}%</td>
                            <td class="py-3 px-4 text-sm font-semibold text-matn">{{ round($result->score_average) }}%</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    $result->risk_level === 'high' ? 'bg-red-500/20 text-red-400' : 
                                    ($result->risk_level === 'low' ? 'bg-green-500/20 text-green-400' : 
                                    'bg-yellow-500/20 text-yellow-400')
                                }}">
                                    {{ $result->risk_emoji }} {{ $result->risk_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-matn2">{{ $result->completed_at->format('d.m.Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.results.show', $result) }}" class="bg-fon3 hover:bg-fon2 text-matn px-2 py-1 rounded text-sm transition-all duration-200" title="Ko'rish">👁️</a>
                                    <form action="{{ route('admin.results.destroy', $result) }}" method="POST" class="inline"
                                        onsubmit="return confirm('O\'chirilsinmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-2 py-1 rounded text-sm transition-all duration-200" title="O'chirish">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-12 text-matn2">Natijalar topilmadi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-chegara">
            {{ $results->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
