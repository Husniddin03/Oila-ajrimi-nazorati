@extends('layouts.admin')
@section('title', 'Savol qo\'shish')
@section('page-title', 'Savol qo\'shish')

@section('content')
    <div style="max-width:640px;">
        <div style="margin-bottom:20px;">
            <a href="{{ route('admin.tests.questions.index', $test) }}" class="btn btn-ikkinchi">← Savollar</a>
        </div>

        <div class="karta">
            <div class="karta-sarlavha" style="margin-bottom:4px;">{{ $test->emoji }} {{ $test->title }}</div>
            <div style="font-size:.8rem;color:var(--matn2);margin-bottom:20px;">Yangi savol qo'shish</div>

            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tests.questions.store', $test) }}" method="POST">
                @csrf
                <div class="form-guruh">
                    <label class="form-label">Savol matni *</label>
                    <textarea name="question_text" class="form-input" rows="3" required placeholder="Savol matnini kiriting...">{{ old('question_text') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-guruh">
                        <label class="form-label">Savol turi *</label>
                        <select name="question_type" class="form-input" id="savolTuri" required
                            onchange="turiAlmashtir(this.value)">
                            <option value="scale" {{ old('question_type') === 'scale' ? 'selected' : '' }}>🎯 Shkala (1-5)
                            </option>
                            <option value="single_choice" {{ old('question_type') === 'single_choice' ? 'selected' : '' }}>⚪
                                Bir javob</option>
                            <option value="multiple_choice"
                                {{ old('question_type') === 'multiple_choice' ? 'selected' : '' }}>☑️ Ko'p javob</option>
                            <option value="text" {{ old('question_type') === 'text' ? 'selected' : '' }}>📝 Erkin matn
                            </option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Kategoriya</label>
                        <select name="category_tag" class="form-input">
                            <option value="muloqot" {{ old('category_tag') === 'muloqot' ? 'selected' : '' }}>💬 Muloqot
                            </option>
                            <option value="emotsional" {{ old('category_tag') === 'emotsional' ? 'selected' : '' }}>❤️
                                Emotsional</option>
                            <option value="moliyaviy" {{ old('category_tag') === 'moliyaviy' ? 'selected' : '' }}>💰
                                Moliyaviy</option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Tartib raqami</label>
                        <input type="number" name="order" class="form-input" value="{{ old('order', 0) }}">
                    </div>
                </div>

                <!-- JAVOB VARIANTLARI (faqat choice uchun) -->
                <div id="optionsSection" style="display:none;">
                    <div
                        style="font-size:.8rem;color:var(--matn2);margin-bottom:10px;text-transform:uppercase;letter-spacing:.06em;">
                        Javob variantlari</div>
                    <div id="optionsList">
                        @for ($i = 0; $i < 5; $i++)
                            <div style="display:grid;grid-template-columns:1fr 80px 36px;gap:8px;margin-bottom:8px;">
                                <input type="text" name="options[{{ $i }}][text]" class="form-input"
                                    placeholder="Variant {{ $i + 1 }}">
                                <input type="number" name="options[{{ $i }}][value]" class="form-input"
                                    value="{{ $i + 1 }}" min="1" max="5" placeholder="Ball">
                                <button type="button" onclick="this.closest('div').remove()"
                                    style="background:rgba(233,69,96,.1);border:1px solid rgba(233,69,96,.2);color:var(--aksent);border-radius:var(--radius2);cursor:pointer;">✕</button>
                            </div>
                        @endfor
                    </div>
                    <button type="button" class="btn btn-yashil btn-sm" onclick="variantQosh()">+ Variant qo'shish</button>
                </div>

                <div style="display:flex;gap:10px;margin-top:20px;">
                    <button type="submit" class="btn btn-asosiy">💾 Saqlash</button>
                    <a href="{{ route('admin.tests.questions.index', $test) }}" class="btn btn-ikkinchi">Bekor qilish</a>
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
            div.style.cssText = 'display:grid;grid-template-columns:1fr 80px 36px;gap:8px;margin-bottom:8px;';
            div.innerHTML = `
    <input type="text" name="options[${variantRaqam}][text]" class="form-input" placeholder="Variant ${variantRaqam+1}">
    <input type="number" name="options[${variantRaqam}][value]" class="form-input" value="${variantRaqam+1}" min="1" max="5">
    <button type="button" onclick="this.closest('div').remove()" style="background:rgba(233,69,96,.1);border:1px solid rgba(233,69,96,.2);color:var(--aksent);border-radius:8px;cursor:pointer;">✕</button>
  `;
            list.appendChild(div);
            variantRaqam++;
        }
        turiAlmashtir(document.getElementById('savolTuri').value);
    </script>
@endpush
