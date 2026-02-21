@extends('layouts.admin')
@section('title', isset($recommendation) ? 'Tavsiyani tahrirlash' : 'Yangi tavsiya')
@section('page-title', isset($recommendation) ? 'Tavsiyani tahrirlash' : 'Yangi tavsiya')

@section('content')
    <div style="max-width:640px;">
        <div style="margin-bottom:20px;">
            <a href="{{ route('admin.recommendations.index') }}" class="btn btn-ikkinchi">← Orqaga</a>
        </div>
        <div class="karta">
            <div class="karta-sarlavha" style="margin-bottom:20px;">
                {{ isset($recommendation) ? 'Tavsiyani tahrirlash' : 'Yangi tavsiya yaratish' }}
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

            <form
                action="{{ isset($recommendation) ? route('admin.recommendations.update', $recommendation) : route('admin.recommendations.store') }}"
                method="POST">
                @csrf
                @if (isset($recommendation))
                    @method('PUT')
                @endif

                <div class="form-guruh">
                    <label class="form-label">Sarlavha *</label>
                    <input type="text" name="title" class="form-input"
                        value="{{ old('title', $recommendation->title ?? '') }}" required>
                </div>
                <div class="form-guruh">
                    <label class="form-label">Tavsif *</label>
                    <textarea name="description" class="form-input" rows="3" required>{{ old('description', $recommendation->description ?? '') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-guruh">
                        <label class="form-label">Emoji/Icon</label>
                        <input type="text" name="icon" class="form-input"
                            value="{{ old('icon', $recommendation->icon ?? '💡') }}" maxlength="5">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Rang</label>
                        <select name="color" class="form-input">
                            @foreach (['yashil' => 'Yashil', 'sariq' => 'Sariq', 'qizil' => 'Qizil', 'moviy' => 'Moviy'] as $v => $l)
                                <option value="{{ $v }}"
                                    {{ old('color', $recommendation->color ?? 'yashil') === $v ? 'selected' : '' }}>
                                    {{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Xavf darajasi</label>
                        <select name="risk_level" class="form-input">
                            <option value="all"
                                {{ old('risk_level', $recommendation->risk_level ?? '') === 'all' ? 'selected' : '' }}>🔵
                                Barchasi</option>
                            <option value="high"
                                {{ old('risk_level', $recommendation->risk_level ?? '') === 'high' ? 'selected' : '' }}>🔴
                                Yuqori</option>
                            <option value="medium"
                                {{ old('risk_level', $recommendation->risk_level ?? '') === 'medium' ? 'selected' : '' }}>
                                🟡 O'rta</option>
                            <option value="low"
                                {{ old('risk_level', $recommendation->risk_level ?? '') === 'low' ? 'selected' : '' }}>🟢
                                Past</option>
                        </select>
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Kategoriya</label>
                        <input type="text" name="category" class="form-input"
                            value="{{ old('category', $recommendation->category ?? '') }}"
                            placeholder="emotsional, moliyaviy...">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Teglar (vergul bilan)</label>
                        <input type="text" name="tags" class="form-input"
                            value="{{ old('tags', isset($recommendation) ? implode(', ', $recommendation->tags ?? []) : '') }}"
                            placeholder="Psixolog, Yordam">
                    </div>
                    <div class="form-guruh">
                        <label class="form-label">Tartib raqami</label>
                        <input type="number" name="order" class="form-input"
                            value="{{ old('order', $recommendation->order ?? 0) }}">
                    </div>
                    <div class="form-guruh" style="padding-top:28px;">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $recommendation->is_active ?? true) ? 'checked' : '' }}
                                style="accent-color:var(--aksent);width:16px;height:16px;">
                            <span class="form-label" style="margin:0;">Faol holat</span>
                        </label>
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn btn-asosiy">💾 Saqlash</button>
                    <a href="{{ route('admin.recommendations.index') }}" class="btn btn-ikkinchi">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection
