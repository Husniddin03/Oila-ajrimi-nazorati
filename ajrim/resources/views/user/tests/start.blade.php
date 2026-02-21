@extends('layouts.user')
@section('title', $test->title)

@push('styles')
    <style>
        .savol-karta {
            background: var(--karta);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--soya);
            border: 1px solid rgba(232, 226, 218, .6);
            max-width: 700px;
            margin: 0 auto;
        }

        .savol-raqam {
            font-size: .75rem;
            color: var(--matn2);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 8px;
        }

        .savol-matn {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            font-size: .78rem;
            color: var(--matn2);
            margin-bottom: 8px;
        }

        .scale-sarlavha {
            display: flex;
            justify-content: space-between;
            font-size: .7rem;
            color: var(--matn3);
            margin-bottom: 8px;
        }

        .scale-qator {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 24px;
        }

        .scale-btn {
            padding: 14px 6px;
            border-radius: var(--radius2);
            border: 2px solid var(--chegara);
            background: var(--fon);
            cursor: pointer;
            transition: all .2s;
            font-family: 'Jost', sans-serif;
            font-size: .82rem;
            font-weight: 500;
            text-align: center;
        }

        .scale-btn:hover {
            border-color: var(--asosiy);
            background: rgba(45, 74, 62, .05);
        }

        .scale-btn.tanlandi {
            border-color: var(--asosiy);
            background: var(--asosiy);
            color: #fff;
        }

        .scale-oy {
            font-size: .65rem;
            color: inherit;
            display: block;
            margin-top: 4px;
            opacity: .8;
        }

        .nav-btnlar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
        }

        .savol-counter {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            color: var(--matn2);
        }

        .savol-counter span {
            color: var(--asosiy);
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <div style="max-width:700px;margin:0 auto;">
        <!-- HEADER -->
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="font-size:2rem;">{{ $test->emoji }}</div>
            <div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;">{{ $test->title }}
                </div>
                <div style="font-size:.8rem;color:var(--matn2);">{{ $test->activeQuestions->count() }} savol • ⏱️
                    {{ $test->duration_minutes }} daqiqa</div>
            </div>
            <a href="{{ route('user.tests.index') }}" class="btn btn-ikkinchi" style="margin-left:auto;">← Orqaga</a>
        </div>

        <!-- PROGRESS -->
        <div style="margin-bottom:24px;">
            <div class="progress-info">
                <span id="progressMatn">1 / {{ $test->activeQuestions->count() }}</span>
                <span id="progressFoiz">0%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width:0;background:var(--asosiy);"></div>
            </div>
        </div>

        <!-- FORM -->
        <form action="{{ route('user.tests.submit', $test) }}" method="POST" id="testForm">
            @csrf

            @foreach ($test->activeQuestions as $index => $question)
                <div class="savol-karta" id="savol-{{ $index }}" style="{{ $index > 0 ? 'display:none;' : '' }}">
                    <div class="savol-raqam">Savol {{ $index + 1 }} / {{ $test->activeQuestions->count() }}</div>
                    <div class="savol-matn">{{ $question->question_text }}</div>

                    @if ($question->question_type === 'scale')
                        <div class="scale-sarlavha">
                            <span>Umuman yo'q</span>
                            <span>Har doim</span>
                        </div>
                        <div class="scale-qator">
                            @foreach ([1 => 'Umuman yo\'q', 2 => 'Kamdan-kam', 3 => 'Ba\'zan', 4 => 'Tez-tez', 5 => 'Har doim'] as $val => $label)
                                <label class="scale-btn" onclick="scaleTanla(this, {{ $index }})">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $val }}"
                                        style="display:none;">
                                    <span
                                        style="font-size:1.1rem;font-weight:700;display:block;">{{ $val }}</span>
                                    <span class="scale-oy">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question->question_type === 'single_choice')
                        <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:24px;">
                            @foreach ($question->options as $option)
                                <label
                                    style="display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:var(--radius2);border:2px solid var(--chegara);background:var(--fon);cursor:pointer;transition:all .2s;"
                                    onclick="this.style.borderColor='var(--asosiy)';this.style.background='rgba(45,74,62,.05)'">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->value }}"
                                        style="accent-color:var(--asosiy);">
                                    {{ $option->option_text }}
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <div class="nav-btnlar">
                        @if ($index > 0)
                            <button type="button" class="btn btn-ikkinchi"
                                onclick="savolAlmashtir({{ $index - 1 }}, {{ $index }})">← Oldingi</button>
                        @else
                            <div></div>
                        @endif

                        <div class="savol-counter">
                            <span>{{ $index + 1 }}</span> / {{ $test->activeQuestions->count() }}
                        </div>

                        @if ($index < $test->activeQuestions->count() - 1)
                            <button type="button" class="btn btn-asosiy"
                                onclick="keyingi({{ $index }}, {{ $index + 1 }})">Keyingi →</button>
                        @else
                            <button type="submit" class="btn btn-aksent" id="submitBtn">🎯 Yakunlash</button>
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
            const qator = el.closest('.scale-qator');
            qator.querySelectorAll('.scale-btn').forEach(b => b.classList.remove('tanlandi'));
            el.classList.add('tanlandi');
            el.querySelector('input').checked = true;
            const val = el.querySelector('input').value;
            javoblar[savolIdx] = val;
            progressYangi(savolIdx + 1);
        }

        function savolAlmashtir(keyingiIdx, joriyIdx) {
            document.getElementById('savol-' + joriyIdx).style.display = 'none';
            document.getElementById('savol-' + keyingiIdx).style.display = 'block';
            progressYangi(keyingiIdx + 1);
        }

        function keyingi(joriyIdx, keyingiIdx) {
            const joriy = document.getElementById('savol-' + joriyIdx);
            const tanlandi = joriy.querySelector('input:checked');
            if (!tanlandi) {
                tost('Iltimos, javob tanlang!', 'err');
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
                tost('Barcha savollarga javob bering!', 'err');
            }
        });
    </script>
@endpush
