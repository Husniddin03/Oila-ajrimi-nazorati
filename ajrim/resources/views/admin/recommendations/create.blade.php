@extends('layouts.admin')
@section('title', isset($recommendation) ? 'Tavsiyani tahrirlash' : 'Yangi tavsiya')
@section('page-title', isset($recommendation) ? 'Tavsiyani tahrirlash' : 'Yangi tavsiya')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-5">
            <a href="{{ route('admin.recommendations.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">← Orqaga</a>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6">
            <h3 class="font-playfair text-lg text-matn mb-6">
                {{ isset($recommendation) ? 'Tavsiyani tahrirlash' : 'Yangi tavsiya yaratish' }}
            </h3>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 mb-6">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $e)
                            <li class="text-red-400 text-sm">• {{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($recommendation) ? route('admin.recommendations.update', $recommendation) : route('admin.recommendations.store') }}" method="POST">
                @csrf
                @if (isset($recommendation))
                    @method('PUT')
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Sarlavha *</label>
                        <input type="text" name="title" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('title', $recommendation->title ?? '') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Tavsif *</label>
                        <textarea name="description" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" rows="3" required>{{ old('description', $recommendation->description ?? '') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Emoji/Icon</label>
                            <input type="text" name="icon" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('icon', $recommendation->icon ?? '💡') }}" maxlength="5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Rang</label>
                            <select name="color" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                                @foreach (['yashil' => 'Yashil', 'sariq' => 'Sariq', 'qizil' => 'Qizil', 'moviy' => 'Moviy'] as $v => $l)
                                    <option value="{{ $v }}" {{ old('color', $recommendation->color ?? 'yashil') === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Xavf darajasi</label>
                            <select name="risk_level" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                                <option value="all" {{ old('risk_level', $recommendation->risk_level ?? '') === 'all' ? 'selected' : '' }}>🔵 Barchasi</option>
                                <option value="high" {{ old('risk_level', $recommendation->risk_level ?? '') === 'high' ? 'selected' : '' }}>🔴 Yuqori</option>
                                <option value="medium" {{ old('risk_level', $recommendation->risk_level ?? '') === 'medium' ? 'selected' : '' }}>🟡 O'rta</option>
                                <option value="low" {{ old('risk_level', $recommendation->risk_level ?? '') === 'low' ? 'selected' : '' }}>🟢 Past</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Kategoriya</label>
                            <input type="text" name="category" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('category', $recommendation->category ?? '') }}" placeholder="emotsional, moliyaviy...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Teglar (vergul bilan)</label>
                            <input type="text" name="tags" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('tags', isset($recommendation) ? implode(', ', $recommendation->tags ?? []) : '') }}" placeholder="Psixolog, Yordam">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Tartib raqami</label>
                            <input type="number" name="order" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('order', $recommendation->order ?? 0) }}">
                        </div>
                        <div class="flex items-center pt-7">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $recommendation->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 text-aksent bg-fon3 border-chegara rounded focus:ring-aksent focus:ring-2">
                                <span class="text-sm font-medium text-matn2">Faol holat</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-6 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">💾 Saqlash</button>
                    <a href="{{ route('admin.recommendations.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-6 py-2.5 rounded-lg transition-all duration-200">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection
