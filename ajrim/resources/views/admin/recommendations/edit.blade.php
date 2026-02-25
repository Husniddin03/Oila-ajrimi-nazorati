@extends('layouts.admin')
@section('title', 'Tavsiyani tahrirlash')
@section('page-title', 'Tavsiyani tahrirlash')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-sm text-matn2 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-aksent transition-colors">Dashboard</a>
            <span>›</span>
            <a href="{{ route('admin.recommendations.index') }}" class="hover:text-aksent transition-colors">Tavsiyalar</a>
            <span>›</span>
            <span>Tahrirlash</span>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.recommendations.update', $recommendation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-karta border border-chegara rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- TITLE -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-matn2 mb-2">Sarlavha *</label>
                        <input type="text" name="title" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('title', $recommendation->title) }}" required placeholder="Tavsiya sarlavhasi">
                        @error('title')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-matn2 mb-2">Tavsif *</label>
                        <textarea name="description" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" rows="4" required placeholder="Tavsiya tavsifi">{{ old('description', $recommendation->description) }}</textarea>
                        @error('description')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ICON -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Icon</label>
                        <input type="text" name="icon" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('icon', $recommendation->icon) }}" placeholder="💡">
                        @error('icon')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- COLOR -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Rang</label>
                        <select name="color" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                            <option value="yashil" {{ old('color', $recommendation->color) === 'yashil' ? 'selected' : '' }}>🟢 Yashil</option>
                            <option value="sariq" {{ old('color', $recommendation->color) === 'sariq' ? 'selected' : '' }}>🟡 Sariq</option>
                            <option value="qizil" {{ old('color', $recommendation->color) === 'qizil' ? 'selected' : '' }}>🔴 Qizil</option>
                            <option value="kok" {{ old('color', $recommendation->color) === 'kok' ? 'selected' : '' }}>🔵 Ko'k</option>
                            <option value="binafsha" {{ old('color', $recommendation->color) === 'binafsha' ? 'selected' : '' }}>🟣 Binafsha</option>
                        </select>
                        @error('color')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- RISK LEVEL -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Xavf darajasi</label>
                        <select name="risk_level" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200">
                            <option value="low" {{ old('risk_level', $recommendation->risk_level) === 'low' ? 'selected' : '' }}>🟢 Past</option>
                            <option value="medium" {{ old('risk_level', $recommendation->risk_level) === 'medium' ? 'selected' : '' }}>🟡 O'rta</option>
                            <option value="high" {{ old('risk_level', $recommendation->risk_level) === 'high' ? 'selected' : '' }}>🔴 Yuqori</option>
                        </select>
                        @error('risk_level')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- CATEGORY -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Kategoriya</label>
                        <input type="text" name="category" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('category', $recommendation->category) }}" placeholder="Muloqot">
                        @error('category')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- TAGS -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-matn2 mb-2">Taglar (vergul bilan ajrating)</label>
                        <input type="text" name="tags" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('tags', implode(', ', $recommendation->tags ?? [])) }}" placeholder="muloqot, oila, yordam">
                        @error('tags')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ORDER -->
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Tartib raqami</label>
                        <input type="number" name="order" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('order', $recommendation->order) }}" min="0">
                        @error('order')
                            <div class="mt-1 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ACTIVE STATUS -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="isActive" class="w-4 h-4 text-aksent bg-fon3 border-chegara rounded focus:ring-aksent focus:ring-2" {{ old('is_active', $recommendation->is_active) ? 'checked' : '' }}>
                        <label for="isActive" class="ml-2 text-sm text-matn">Faol</label>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-chegara">
                    <a href="{{ route('admin.recommendations.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">Bekor qilish</a>
                    <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200">Saqlash</button>
                </div>
            </div>
        </form>
    </div>
@endsection
