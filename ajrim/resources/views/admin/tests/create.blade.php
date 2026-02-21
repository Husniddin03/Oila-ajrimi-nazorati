@extends('layouts.admin')
@section('title', isset($test) ? 'Testni tahrirlash' : 'Yangi test')
@section('page-title', isset($test) ? 'Testni tahrirlash' : 'Yangi test')

@section('content')
    <div style="max-width:640px;">
        <div style="margin-bottom:20px;">
            <a href="{{ route('admin.tests.index') }}" class="btn btn-ikkinchi">← Orqaga</a>
        </div>
        <div class="karta">
            <div class="karta-sarlavha" style="margin-bottom:20px;">
                {{ isset($test) ? $test->title . ' ni tahrirlash' : 'Yangi test yaratish' }}
            </div>

            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($test) ? route('admin.tests.update', $test) : route('admin.tests.store') }}"
                method="POST">
                @csrf
                @if (isset($test))
                    @method('PUT')
                @endif

                <div class="form-guruh">
                    <label class="form-label">Test nomi *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $test->title ?? '') }}"
                        required>
                </div>
                <div class="form-guruh">
                    <label class="form-label">Tavsif</label>
                    <textarea name="description" class="form-input" rows="3">{{ old('description', $test->description ?? '') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-guruh">
                        <label class="form-label">Emoji *</label>
                        <input type="text" name="emoji" class="form-input"
                            value="{{ old('emoji', $test->emoji ?? '📋') }}" maxlength="5" required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Rang *</label>
                        <input type="text" name="color" class="form-input"
                            value="{{ old('color', $test->color ?? '#4a7c59') }}" placeholder="#4a7c59" required>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Kategoriya *</label>
                        <select name="category" class="form-input" required>
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('category', $test->category ?? '') === $key ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Davomiyligi (daqiqa)</label>
                        <input type="number" name="duration_minutes" class="form-input"
                            value="{{ old('duration_minutes', $test->duration_minutes ?? 15) }}" min="1"
                            max="120">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Tartib raqami</label>
                        <input type="number" name="order" class="form-input"
                            value="{{ old('order', $test->order ?? 0) }}">
                    </div>
                    <div class="form-guruh" style="display:flex;align-items:center;padding-top:28px;">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $test->is_active ?? true) ? 'checked' : '' }}
                                style="accent-color:var(--aksent);width:16px;height:16px;">
                            <span class="form-label" style="margin:0;">Faol holat</span>
                        </label>
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn btn-asosiy">💾 Saqlash</button>
                    <a href="{{ route('admin.tests.index') }}" class="btn btn-ikkinchi">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection
