@extends('layouts.admin')
@section('title', 'Natijalar')
@section('page-title', 'Natijalar')

@section('content')
    <div class="section-sarlavha">
        <h2>📈 Test natijalari</h2>
        <div style="font-size:.82rem;color:var(--matn2);">{{ $results->total() }} ta natija</div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="filter-qator">
        <input type="text" name="search" class="form-input" placeholder="🔍 Foydalanuvchi nomi..."
            value="{{ request('search') }}">
        <select name="risk_level" class="form-input" style="max-width:160px;">
            <option value="">Barcha xavflar</option>
            <option value="high" {{ request('risk_level') === 'high' ? 'selected' : '' }}>🔴 Yuqori</option>
            <option value="medium" {{ request('risk_level') === 'medium' ? 'selected' : '' }}>🟡 O'rta</option>
            <option value="low" {{ request('risk_level') === 'low' ? 'selected' : '' }}>🟢 Past</option>
        </select>
        <select name="test_id" class="form-input" style="max-width:200px;">
            <option value="">Barcha testlar</option>
            @foreach ($allTests as $id => $title)
                <option value="{{ $id }}" {{ request('test_id') == $id ? 'selected' : '' }}>{{ $title }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-ikkinchi">Filtr</button>
        <a href="{{ route('admin.results.index') }}" class="btn btn-ikkinchi">Tozalash</a>
    </form>

    <div class="karta">
        <div class="jadval-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foydalanuvchi</th>
                        <th>Test</th>
                        <th>Emotsional</th>
                        <th>Moliyaviy</th>
                        <th>Muloqot</th>
                        <th>O'rtacha</th>
                        <th>Xavf</th>
                        <th>Sana</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $i => $result)
                        <tr>
                            <td style="color:var(--matn2);">{{ $results->firstItem() + $i }}</td>
                            <td>
                                <div style="font-size:.875rem;">{{ $result->user->name }}</div>
                                <div style="font-size:.7rem;color:var(--matn2);">{{ $result->user->email }}</div>
                            </td>
                            <td style="color:var(--matn2);">{{ Str::limit($result->test->title, 25) }}</td>
                            <td style="color:var(--moviy);">{{ round($result->score_emotional) }}%</td>
                            <td style="color:var(--sariq);">{{ round($result->score_financial) }}%</td>
                            <td style="color:var(--yashil);">{{ round($result->score_communication) }}%</td>
                            <td style="font-weight:600;">{{ round($result->score_average) }}%</td>
                            <td>
                                <span
                                    class="chip {{ $result->risk_level === 'high' ? 'chip-qizil' : ($result->risk_level === 'low' ? 'chip-yashil' : 'chip-sariq') }}">
                                    {{ $result->risk_emoji }} {{ $result->risk_label }}
                                </span>
                            </td>
                            <td style="color:var(--matn2);">{{ $result->completed_at->format('d.m.Y') }}</td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <a href="{{ route('admin.results.show', $result) }}"
                                        class="btn btn-ikkinchi btn-sm">👁️</a>
                                    <form action="{{ route('admin.results.destroy', $result) }}" method="POST"
                                        onsubmit="return confirm('O\'chirilsinmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xavf btn-sm">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center;padding:40px;color:var(--matn2);">Natijalar
                                topilmadi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $results->appends(request()->query())->links() }}
    </div>
@endsection
