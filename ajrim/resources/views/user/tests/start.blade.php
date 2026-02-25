@extends('layouts.user')
@section('title', $test->title)
@section('page-title', $test->title)

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- PROGRESS -->
        <div class="mb-6">
            <div class="flex justify-between items-center text-xs text-matn2 mb-2">
                <span id="progressMatn">1 / {{ $test->activeQuestions->count() }}</span>
                <span id="progressFoiz">0%</span>
            </div>
            <div class="w-full bg-fon3 h-2 rounded-full overflow-hidden">
                <div class="h-full bg-aksent transition-all duration-300" id="progressFill" style="width: 0%"></div>
            </div>
        </div>

        <!-- FORM -->
        <form action="{{ route('user.tests.submit', $test) }}" method="POST" id="testForm">
            @csrf

            @foreach ($test->activeQuestions as $index => $question)
                <div class="bg-karta border border-chegara rounded-xl p-8 mb-6 {{ $index == 0 ? '' : 'hidden' }}" id="savol-{{ $index }}">
                    <div class="text-xs text-matn2 font-medium tracking-wider uppercase mb-2">Savol {{ $index + 1 }} / {{ $test->activeQuestions->count() }}</div>
                    <div class="font-playfair text-xl font-semibold text-matn mb-6 leading-relaxed">{{ $question->question_text }}</div>

                    @if ($question->question_type === 'scale')
                        <div class="flex justify-between text-xs text-matn3 mb-2">
                            <span>Umuman yo'q</span>
                            <span>Har doim</span>
                        </div>
                        <div class="grid grid-cols-5 gap-2 mb-6">
                            @foreach ([1 => 'Umuman yo\'q', 2 => 'Kamdan-kam', 3 => 'Ba\'zan', 4 => 'Tez-tez', 5 => 'Har doim'] as $val => $label)
                                <label class="block cursor-pointer" onclick="scaleTanla(this, {{ $index }})">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $val }}" class="hidden">
                                    <div class="px-3.5 py-3.5 border-2 border-chegara rounded-lg bg-fon text-center transition-all duration-200 hover:border-aksent hover:bg-fon3">
                                        <span class="text-lg font-bold block">{{ $val }}</span>
                                        <span class="text-xs opacity-80 block mt-1">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question->question_type === 'single_choice')
                        <div class="flex flex-col gap-2 mb-6">
                            @foreach ($question->options as $option)
                                <label class="flex items-center gap-3 p-3 border-2 border-chegara rounded-lg bg-fon cursor-pointer transition-all duration-200 hover:border-aksent hover:bg-fon3" onclick="singleChoiceTanla(this, {{ $index }})">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->value }}" class="text-aksent">
                                    {{ $option->option_text }}
                                </label>
                            @endforeach
                        </div>
                    @elseif($question->question_type === 'multiple_choice')
                        <div class="flex flex-col gap-2 mb-6">
                            @foreach ($question->options as $option)
                                <label class="flex items-center gap-3 p-3 border-2 border-chegara rounded-lg bg-fon cursor-pointer transition-all duration-200 hover:border-aksent hover:bg-fon3" onclick="multipleChoiceTanla(this, {{ $index }})">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->value }}" class="text-aksent">
                                    {{ $option->option_text }}
                                </label>
                            @endforeach
                        </div>
                    @elseif($question->question_type === 'text')
                        <div class="mb-6">
                            <textarea name="answers[{{ $question->id }}]" class="w-full px-4 py-3 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" rows="4" placeholder="Javobingizni bu yerga yozing..." oninput="textTanla(this, {{ $index }})"></textarea>
                        </div>
                    @endif

                    <div class="flex justify-between items-center">
                        @if ($index > 0)
                            <button type="button" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200" onclick="savolAlmashtir({{ $index - 1 }}, {{ $index }})">← Oldingi</button>
                        @else
                            <div></div>
                        @endif

                        <div class="font-playfair text-lg text-matn2">
                            <span class="text-aksent font-bold">{{ $index + 1 }}</span> / {{ $test->activeQuestions->count() }}
                        </div>

                        @if ($index < $test->activeQuestions->count() - 1)
                            <button type="button" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200" onclick="keyingi({{ $index }}, {{ $index + 1 }})">Keyingi →</button>
                        @else
                            <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200" id="submitBtn">🎯 Yakunlash</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const jami = {{ $test->activeQuestions->count() }};
        const javoblar = {};

        function scaleTanla(el, savolIdx) {
            const qator = el.closest('.grid');
            qator.querySelectorAll('label > div').forEach(b => b.classList.remove('border-aksent', 'bg-aksent/10'));
            el.querySelector('div').classList.add('border-aksent', 'bg-aksent/10');
            el.querySelector('input').checked = true;
            const val = el.querySelector('input').value;
            javoblar[savolIdx] = val;
            progressYangi(savolIdx + 1);
        }

        function singleChoiceTanla(el, savolIdx) {
            const qator = el.closest('.flex');
            qator.querySelectorAll('label').forEach(b => b.classList.remove('border-aksent', 'bg-aksent/10'));
            el.classList.add('border-aksent', 'bg-aksent/10');
            el.querySelector('input').checked = true;
            const val = el.querySelector('input').value;
            javoblar[savolIdx] = val;
            progressYangi(savolIdx + 1);
        }

        function multipleChoiceTanla(el, savolIdx) {
            const checkbox = el.querySelector('input');
            if (checkbox.checked) {
                el.classList.add('border-aksent', 'bg-aksent/10');
            } else {
                el.classList.remove('border-aksent', 'bg-aksent/10');
            }
            
            // Get all checked values
            const qator = el.closest('.flex');
            const checked = qator.querySelectorAll('input[type="checkbox"]:checked');
            const values = Array.from(checked).map(cb => cb.value);
            javoblar[savolIdx] = values;
            progressYangi(savolIdx + 1);
        }

        function textTanla(el, savolIdx) {
            const val = el.value;
            if (val.trim()) {
                javoblar[savolIdx] = val;
                progressYangi(savolIdx + 1);
            }
        }

        function savolAlmashtir(keyingiIdx, joriyIdx) {
            document.getElementById('savol-' + joriyIdx).style.display = 'none';
            document.getElementById('savol-' + keyingiIdx).style.display = 'block';
            progressYangi(keyingiIdx + 1);
        }

        function keyingi(joriyIdx, keyingiIdx) {
            const joriy = document.getElementById('savol-' + joriyIdx);
            
            // Check if question has answer
            const radioChecked = joriy.querySelector('input[type="radio"]:checked');
            const checkboxChecked = joriy.querySelector('input[type="checkbox"]:checked');
            const textValue = joriy.querySelector('textarea')?.value?.trim();
            
            if (!radioChecked && !checkboxChecked && !textValue) {
                alert('Iltimos, javob tanlang yoki yozing!');
                return;
            }
            savolAlmashtir(keyingiIdx, joriyIdx);
        }

        function progressYangi(n) {
            const foiz = Math.round(n / jami * 100);
            document.getElementById('progressMatn').textContent = n + ' / ' + jami;
            document.getElementById('progressFoiz').textContent = foiz + '%';
            document.getElementById('progressFill').style.width = foiz + '%';
        }

        document.getElementById('testForm').addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input[type="radio"][name^="answers"]');
            const savollar = {};
            inputs.forEach(inp => {
                const name = inp.name;
                if (!savollar[name]) savollar[name] = false;
                if (inp.checked) savollar[name] = true;
            });

            const javobBerilmagan = Object.values(savollar).filter(v => !v).length;
            if (javobBerilmagan > 0) {
                e.preventDefault();
                alert('Barcha savollarga javob bering!');
            }
        });
    </script>
@endpush
