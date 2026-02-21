@extends('layouts.admin')
@section('title', 'Savollar — ' . $test->title)
@section('page-title', 'Savollar')

@section('content')
    <div class="section-sarlavha">
        <h2>❓ {{ $test->title }} — Savollar</h2>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.tests.index') }}" class="btn btn-ikkinchi">← Testlar</a>
            <a href="{{ route('admin.tests.questions.create', $test) }}" class="btn btn-asosiy">+ Savol qo'shish</a>
        </div>
    </div>

    <div class="karta">
        <div class="jadval-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Savol matni</th>
                        <th>Turi</th>
                        <th>Kategoriya</th>
                        <th>Holat</th>
                        <th>Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                        <tr>
                            <td style="color:var(--matn2);">{{ $q->order }}</td>
                            <td style="max-width:300px;">{{ Str::limit($q->question_text, 60) }}</td>
                            <td>
                                <span class="chip chip-moviy">
                                    {{ match ($q->question_type) {
                                        'scale' => '🎯 Shkala',
                                        'single_choice' => '⚪ Bir javob',
                                        'multiple_choice' => '☑️ Ko\'p javob',
                                        default => '📝 Matn',
                                    } }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="chip {{ match ($q->category_tag) {
                                        'emotsional' => 'chip-qizil',
                                        'moliyaviy' => 'chip-sariq',
                                        default => 'chip-moviy',
                                    } }}">
                                    {{ match ($q->category_tag) {
                                        'emotsional' => '❤️ Emotsional',
                                        'moliyaviy' => '💰 Moliyaviy',
                                        default => '💬 Muloqot',
                                    } }}
                                </span>
                            </td>
                            <td>
                                <span class="chip {{ $q->is_active ? 'chip-yashil' : 'chip-qizil' }}">
                                    {{ $q->is_active ? 'Faol' : 'Faol emas' }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:5px;">
                                    <a href="{{ route('admin.tests.questions.edit', [$test, $q]) }}"
                                        class="btn btn-ikkinchi btn-sm">✏️</a>
                                    <form action="{{ route('admin.tests.questions.destroy', [$test, $q]) }}" method="POST"
                                        onsubmit="return confirm('O\'chirilsinmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xavf btn-sm">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:40px;color:var(--matn2);">
                                Savollar mavjud emas. <a href="{{ route('admin.tests.questions.create', $test) }}"
                                    style="color:var(--aksent);">Qo'shing</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
