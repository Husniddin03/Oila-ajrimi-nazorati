@extends('layouts.admin')
@section('title', 'Savolni tahrirlash')
@section('page-title', 'Savolni tahrirlash')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-sm text-matn2 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-aksent transition-colors">Dashboard</a>
            <span>›</span>
            <a href="{{ route('admin.tests.index') }}" class="hover:text-aksent transition-colors">Testlar</a>
            <span>›</span>
            <a href="{{ route('admin.tests.questions.index', $test) }}" class="hover:text-aksent transition-colors">Savollar</a>
            <span>›</span>
            <span>Tahrirlash</span>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.tests.questions.update', [$test, $question]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-karta border border-chegara rounded-xl p-6">
                <!-- TEST INFO -->
                <div class="mb-6 p-4 bg-fon3 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl">{{ $test->emoji }}</div>
                        <div>
                            <div class="font-medium text-matn">{{ $test->title }}</div>
                            <div class="text-sm text-matn2">{{ $test->activeQuestions->count() }} ta savol</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- QUESTION TEXT -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-matn2 mb-2">Savol matni *</label>
                        <textarea name="question_text" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" rows="3" required placeholder="Savol matnini kiriting...">{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- QUESTION TYPE -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Savol turi *</label>
                        <select name="question_type" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" id="savolTuri" required onchange="turiAlmashtir(this.value)">
                            <option value="scale" {{ old('question_type', $question->question_type) === 'scale' ? 'selected' : '' }}>🎯 Shkala (1-5)</option>
                            <option value="single_choice" {{ old('question_type', $question->question_type) === 'single_choice' ? 'selected' : '' }}>⚪ Bir javob</option>
                            <option value="multiple_choice" {{ old('question_type', $question->question_type) === 'multiple_choice' ? 'selected' : '' }}>☑️ Ko'p javob</option>
                            <option value="text" {{ old('question_type', $question->question_type) === 'text' ? 'selected' : '' }}>📝 Erkin matn</option>
                        </select>
                        @error('question_type')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- CATEGORY -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Kategoriya</label>
                        <select name="category_tag" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                            <option value="muloqot" {{ old('category_tag', $question->category_tag) === 'muloqot' ? 'selected' : '' }}>💬 Muloqot</option>
                            <option value="emotsional" {{ old('category_tag', $question->category_tag) === 'emotsional' ? 'selected' : '' }}>❤️ Emotsional</option>
                            <option value="moliyaviy" {{ old('category_tag', $question->category_tag) === 'moliyaviy' ? 'selected' : '' }}>💰 Moliyaviy</option>
                        </select>
                        @error('category_tag')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ORDER -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Tartib raqami</label>
                        <input type="number" name="order" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('order', $question->order) }}" min="0">
                        @error('order')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ACTIVE STATUS -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="isActive" class="w-4 h-4 text-aksent bg-fon3 border-chegara rounded focus:ring-aksent focus:ring-2" {{ old('is_active', $question->is_active) ? 'checked' : '' }}>
                        <label for="isActive" class="ml-2 text-sm text-matn">Faol</label>
                    </div>
                </div>

                <!-- JAVOB VARIANTLARI (faqat choice uchun) -->
                <div id="optionsSection" class="mt-6 {{ in_array($question->question_type, ['single_choice', 'multiple_choice']) ? '' : 'hidden' }}">
                    <div class="text-xs text-matn2 mb-3 uppercase tracking-wider">Javob variantlari</div>
                    <div id="optionsList" class="space-y-2">
                        @foreach ($question->options as $index => $option)
                            <div class="grid grid-cols-[1fr,80px,36px] gap-2">
                                <input type="text" name="options[{{ $index }}][text]" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('options.'.$index.'.text', $option->option_text) }}" placeholder="Variant {{ $index + 1 }}">
                                <input type="number" name="options[{{ $index }}][value]" class="px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('options.'.$index.'.value', $option->value) }}" min="1" max="5">
                                <button type="button" onclick="this.closest('div).remove()" class="bg-red-500/10 border border-red-500/20 text-aksent rounded-lg hover:bg-red-500/20 transition-colors">✕</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="variantQosh()" class="mt-3 bg-fon3 hover:bg-fon2 text-matn px-3 py-2 rounded-lg text-sm transition-all duration-200">+ Variant qo'shish</button>
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-chegara">
                    <a href="{{ route('admin.tests.questions.index', $test) }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">Bekor qilish</a>
                    <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200">Saqlash</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let variantRaqam = {{ $question->options->count() }};

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
