@extends('layouts.admin')
@section('title', 'Testni tahrirlash')
@section('page-title', 'Testni tahrirlash')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-5">
            <a href="{{ route('admin.tests.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2 rounded-lg transition-all duration-200">← Orqaga</a>
        </div>
        <div class="bg-karta border border-chegara rounded-xl p-6">
            <h3 class="font-playfair text-lg text-matn mb-6">
                {{ $test->title }} ni tahrirlash
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

            <form action="{{ route('admin.tests.update', $test) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Test nomi *</label>
                        <input type="text" name="title" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('title', $test->title) }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-matn2 mb-2">Tavsif</label>
                        <textarea name="description" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" rows="3">{{ old('description', $test->description) }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Emoji *</label>
                            <input type="text" name="emoji" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('emoji', $test->emoji) }}" maxlength="5" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Rang *</label>
                            <input type="text" name="color" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('color', $test->color) }}" placeholder="#4a7c59" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Kategoriya *</label>
                            <select name="category" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" required>
                                @foreach ($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $test->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Davomiyligi (daqiqa)</label>
                            <input type="number" name="duration_minutes" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('duration_minutes', $test->duration_minutes) }}" min="1" max="120">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-matn2 mb-2">Tartib raqami</label>
                            <input type="number" name="order" class="w-full px-3 py-2 bg-fon3 border border-chegara rounded-lg text-matn placeholder-matn3 focus:outline-none focus:border-aksent focus:ring-2 focus:ring-aksent/20 transition-all duration-200" value="{{ old('order', $test->order) }}">
                        </div>
                        <div class="flex items-center pt-7">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $test->is_active) ? 'checked' : '' }} class="w-4 h-4 text-aksent bg-fon3 border-chegara rounded focus:ring-aksent focus:ring-2">
                                <span class="text-sm font-medium text-matn2">Faol holat</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-aksent hover:bg-red-600 text-white px-6 py-2.5 rounded-lg transition-all duration-200 transform hover:-translate-y-0.5">💾 Saqlash</button>
                    <a href="{{ route('admin.tests.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-6 py-2.5 rounded-lg transition-all duration-200">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>
@endsection
