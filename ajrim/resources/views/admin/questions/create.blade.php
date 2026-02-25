@extends('layouts.admin')
@section('title', 'Savol qo\'shish')
@section('page-title', 'Savol qo\'shish')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-5">
            <a href="{{ route('admin.tests.questions.index', $test) }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">← Savollar</a>
        </div>

        <div class="bg-karta border border-chegara rounded-xl p-6">
            <h3 class="font-playfair text-lg text-matn mb-1">{{ $test->emoji }} {{ $test->title }}</h3>
            <p class="text-sm text-matn2 mb-6">Yangi savol qo'shish</p>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $e)
                            <li class="text-red-400 text-sm">• {{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tests.questions.store', $test) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Savol matni *</label>
                        <textarea name="question_text" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" rows="3" required placeholder="Savol matnini kiriting...">{{ old('question_text') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Savol turi *</label>
                            <select name="question_type" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" id="savolTuri" required onchange="turiAlmashtir(this.value)">
                                <option value="scale" {{ old('question_type') === 'scale' ? 'selected' : '' }}>🎯 Shkala (1-5)</option>
                                <option value="single_choice" {{ old('question_type') === 'single_choice' ? 'selected' : '' }}>⚪ Bir javob</option>
                                <option value="multiple_choice" {{ old('question_type') === 'multiple_choice' ? 'selected' : '' }}>☑️ Ko'p javob</option>
                                <option value="text" {{ old('question_type') === 'text' ? 'selected' : '' }}>📝 Erkin matn</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Kategoriya</label>
                            <select name="category_tag" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                                <option value="muloqot" {{ old('category_tag') === 'muloqot' ? 'selected' : '' }}>💬 Muloqot</option>
                                <option value="emotsional" {{ old('category_tag') === 'emotsional' ? 'selected' : '' }}>❤️ Emotsional</option>
                                <option value="moliyaviy" {{ old('category_tag') === 'moliyaviy' ? 'selected' : '' }}>💰 Moliyaviy</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Tartib raqami</label>
                            <input type="number" name="order" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('order', 0) }}">
                        </div>
                    </div>

                    <!-- JAVOB VARIANTLARI (faqat choice uchun) -->
                    <div id="optionsSection" class="hidden">
                        <div class="text-xs text-matn2 mb-3 uppercase tracking-wider">Javob variantlari</div>
                        <div id="optionsList" class="space-y-2">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="grid grid-cols-[1fr,80px,36px] gap-2">
                                    <input type="text" name="options[{{ $i }}][text]" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" placeholder="Variant {{ $i + 1 }}">
                                    <input type="number" name="options[{{ $i }}][value]" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ $i + 1 }}" min="1" max="5" placeholder="Ball">
                                    <button type="button" onclick="this.closest('div').remove()" class="bg-red-500/10 border border-red-500/20 text-aksent rounded-lg hover:bg-red-500/20 transition-colors">✕</button>
                                </div>
                            @endfor
                        </div>
                        <button type="button" class="bg-green-500/20 hover:bg-green-500/30 text-green-400 px-4 py-2 rounded-lg text-sm transition-all duration-200 mt-3" onclick="variantQosh()">+ Variant qo'shish</button>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-6 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">💾 Saqlash</button>
                    <a href="{{ route('admin.tests.questions.index', $test) }}" class="bg-fon3 hover:bg-fon2 text-matn px-6 py-2.5 rounded-lg transition-all duration-200">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let variantRaqam = 5;

        function turiAlmashtir(tur) {
            const sec = document.getElementById('optionsSection');
            sec.style.display = (tur === 'single_choice' || tur === 'multiple_choice') ? 'block' : 'none';
        }

        function variantQosh() {
            const list = document.getElementById('optionsList');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-[1fr,80px,36px] gap-2';
            div.innerHTML = `
                <input type="text" name="options[${variantRaqam}][text]" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" placeholder="Variant ${variantRaqam+1}">
                <input type="number" name="options[${variantRaqam}][value]" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="${variantRaqam+1}" min="1" max="5">
                <button type="button" onclick="this.closest('div').remove()" class="bg-red-500/10 border border-red-500/20 text-aksent rounded-lg hover:bg-red-500/20 transition-colors">✕</button>
            `;
            list.appendChild(div);
            variantRaqam++;
        }
        turiAlmashtir(document.getElementById('savolTuri').value);
    </script>
@endpush
