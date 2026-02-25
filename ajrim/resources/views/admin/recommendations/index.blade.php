@extends('layouts.admin')
@section('title', 'Tavsiyalar')
@section('page-title', 'Tavsiyalar')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-matn flex items-center gap-2">💡 Tavsiyalar</h2>
        <a href="{{ route('admin.recommendations.create') }}" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">+ Yangi tavsiya</a>
    </div>

    <div class="bg-karta border border-chegara rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-fon3 border-b border-chegara">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">#</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Sarlavha</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Xavf darajasi</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Kategoriya</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Holat</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recommendations as $i => $rec)
                        <tr class="border-b border-chegara/30 hover:bg-fon3/50 transition-colors">
                            <td class="py-3 px-4 text-sm text-matn2">{{ $rec->order }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl">{{ $rec->icon }}</span>
                                    <span class="text-sm text-matn">{{ $rec->title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    match ($rec->risk_level) {
                                        'high' => 'bg-red-500/20 text-red-400',
                                        'low' => 'bg-green-500/20 text-green-400',
                                        'all' => 'bg-blue-500/20 text-blue-400',
                                        default => 'bg-yellow-500/20 text-yellow-400',
                                    }
                                }}">
                                    {{ match ($rec->risk_level) {
                                        'high' => '🔴 Yuqori',
                                        'low' => '🟢 Past',
                                        'all' => '🔵 Barcha',
                                        default => '🟡 O\'rta',
                                    } }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-matn2">{{ $rec->category ?? '—' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    $rec->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
                                }}">
                                    {{ $rec->is_active ? 'Faol' : 'Faol emas' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.recommendations.edit', $rec) }}" class="bg-fon3 hover:bg-fon2 text-matn px-2 py-1 rounded text-sm transition-all duration-200" title="Tahrirlash">✏️</a>
                                    <form action="{{ route('admin.recommendations.destroy', $rec) }}" method="POST" class="inline"
                                        onsubmit="return confirm('O\'chirilsinmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-2 py-1 rounded text-sm transition-all duration-200" title="O'chirish">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-matn2">Tavsiyalar mavjud emas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-chegara">
            {{ $recommendations->links() }}
        </div>
    </div>
@endsection
