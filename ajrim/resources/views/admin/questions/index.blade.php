@extends('layouts.admin')
@section('title', 'Savollar — ' . $test->title)
@section('page-title', 'Savollar')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-2xl font-semibold text-matn flex items-center gap-2">❓ {{ $test->title }} — Savollar</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.tests.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">← Testlar</a>
            <a href="{{ route('admin.tests.questions.create', $test) }}" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">+ Savol qo'shish</a>
        </div>
    </div>

    <div class="bg-karta border border-chegara rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-fon3 border-b border-chegara">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">#</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Savol matni</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Turi</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Kategoriya</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Holat</th>
                        <th class="text-left py-3 px-4 text-xs font-medium text-matn2">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                        <tr class="border-b border-chegara/30 hover:bg-fon3/50 transition-colors">
                            <td class="py-3 px-4 text-sm text-matn2">{{ $q->order }}</td>
                            <td class="py-3 px-4 text-sm text-matn max-w-xs truncate">{{ Str::limit($q->question_text, 60) }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-medium">
                                    {{ match ($q->question_type) {
                                        'scale' => '🎯 Shkala',
                                        'single_choice' => '⚪ Bir javob',
                                        'multiple_choice' => '☑️ Ko\'p javob',
                                        default => '📝 Matn',
                                    } }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    match ($q->category_tag) {
                                        'emotsional' => 'bg-red-500/20 text-red-400',
                                        'moliyaviy' => 'bg-yellow-500/20 text-yellow-400',
                                        default => 'bg-blue-500/20 text-blue-400',
                                    }
                                }}">
                                    {{ match ($q->category_tag) {
                                        'emotsional' => '❤️ Emotsional',
                                        'moliyaviy' => '💰 Moliyaviy',
                                        default => '💬 Muloqot',
                                    } }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                                    $q->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
                                }}">
                                    {{ $q->is_active ? 'Faol' : 'Faol emas' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.tests.questions.edit', [$test, $q]) }}" class="bg-fon3 hover:bg-fon2 text-matn px-2 py-1 rounded text-sm transition-all duration-200" title="Tahrirlash">✏️</a>
                                    <form action="{{ route('admin.tests.questions.destroy', [$test, $q]) }}" method="POST" class="inline"
                                        onsubmit="return confirm('O\'chirilsinmi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-2 py-1 rounded text-sm transition-all duration-200" title="O'chirish">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-matn2">
                                Savollar mavjud emas. <a href="{{ route('admin.tests.questions.create', $test) }}" class="text-aksent hover:text-red-400 transition-colors">Qo'shing</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
