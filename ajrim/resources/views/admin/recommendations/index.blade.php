@extends('layouts.admin')
@section('title', 'Tavsiyalar')
@section('page-title', 'Tavsiyalar')

@section('content')
    <div class="section-sarlavha">
        <h2>💡 Tavsiyalar</h2>
        <a href="{{ route('admin.recommendations.create') }}" class="btn btn-asosiy">+ Yangi tavsiya</a>
    </div>

    <div class="karta">
        <div class="jadval-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sarlavha</th>
                        <th>Xavf darajasi</th>
                        <th>Kategoriya</th>
                        <th>Holat</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recommendations as $i => $rec)
                        <tr>
                            <td style="color:var(--matn2);">{{ $rec->order }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span style="font-size:1.2rem;">{{ $rec->icon }}</span>
                                    <span>{{ $rec->title }}</span>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="chip {{ match ($rec->risk_level) {
                                        'high' => 'chip-qizil',
                                        'low' => 'chip-yashil',
                                        'all' => 'chip-moviy',
                                        default => 'chip-sariq',
                                    } }}">
                                    {{ match ($rec->risk_level) {
                                        'high' => '🔴 Yuqori',
                                        'low' => '🟢 Past',
                                        'all' => '🔵 Barcha',
                                        default => '🟡 O\'rta',
                                    } }}
                                </span>
                            </td>
                            <td style="color:var(--matn2);">{{ $rec->category ?? '—' }}</td>
                            <td>
                                <span class="chip {{ $rec->is_active ? 'chip-yashil' : 'chip-qizil' }}">
                                    {{ $rec->is_active ? 'Faol' : 'Faol emas' }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <a href="{{ route('admin.recommendations.edit', $rec) }}"
                                        class="btn btn-ikkinchi btn-sm">✏️</a>
                                    <form action="{{ route('admin.recommendations.destroy', $rec) }}" method="POST"
                                        onsubmit="return confirm('O\'chirilsinmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xavf btn-sm">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:var(--matn2);">Tavsiyalar mavjud
                                emas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $recommendations->links() }}
    </div>
@endsection
