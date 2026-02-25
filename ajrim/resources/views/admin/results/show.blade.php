@extends('layouts.admin')
@section('title', 'Natija tafsilotlari')
@section('page-title', 'Natija tafsilotlari')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-matn flex items-center gap-2">📊 Test natijasi</h2>
        <div class="text-sm text-matn2">{{ $result->user->name }} - {{ $result->test->title }}</div>
    </div>

    <!-- ASOSIY MA'LUMOTLAR -->
    <div class="bg-karta border border-chegara rounded-xl p-6 mb-6">
        <h3 class="font-playfair text-lg text-matn mb-4">👤 Foydalanuvchi ma'lumotlari</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <strong class="text-sm text-matn2">Ism:</strong>
                <div class="text-matn mt-1">{{ $result->user->name }}</div>
            </div>
            <div>
                <strong class="text-sm text-matn2">Email:</strong>
                <div class="text-matn mt-1">{{ $result->user->email }}</div>
            </div>
            @if($result->user->phone)
                <div>
                    <strong class="text-sm text-matn2">Telefon:</strong>
                    <div class="text-matn mt-1">{{ $result->user->phone }}</div>
                </div>
            @endif
            <div>
                <strong class="text-sm text-matn2">Status:</strong>
                <div class="mt-1">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{
                        $result->user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
                    }}">
                        {{ $result->user->status === 'active' ? '✅ Faol' : '❌ Bloklangan' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- TEST MA'LUMOTLARI -->
    <div class="bg-karta border border-chegara rounded-xl p-6 mb-6">
        <h3 class="font-playfair text-lg text-matn mb-4">📝 Test ma'lumotlari</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <strong class="text-sm text-matn2">Test nomi:</strong>
                <div class="text-matn mt-1">{{ $result->test->title }}</div>
            </div>
            <div>
                <strong class="text-sm text-matn2">Boshlanish vaqti:</strong>
                <div class="text-matn mt-1">{{ $result->created_at->format('d.m.Y H:i') }}</div>
            </div>
            <div>
                <strong class="text-sm text-matn2">Tugash vaqti:</strong>
                <div class="text-matn mt-1">{{ $result->completed_at->format('d.m.Y H:i') }}</div>
            </div>
            <div>
                <strong class="text-sm text-matn2">Sarflangan vaqt:</strong>
                <div class="text-matn mt-1">{{ $result->completed_at->diffInMinutes($result->created_at) }} daqiqa</div>
            </div>
        </div>
    </div>

    <!-- BALLAR -->
    <div class="bg-karta border border-chegara rounded-xl p-6 mb-6">
        <h3 class="font-playfair text-lg text-matn mb-4">🎯 Ballar</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 border border-moviy rounded-lg">
                <div class="text-2xl font-bold text-moviy mb-2">{{ round($result->score_emotional) }}%</div>
                <div class="text-sm text-matn2">Emotsional</div>
            </div>
            <div class="text-center p-4 border border-sariq rounded-lg">
                <div class="text-2xl font-bold text-sariq mb-2">{{ round($result->score_financial) }}%</div>
                <div class="text-sm text-matn2">Moliyaviy</div>
            </div>
            <div class="text-center p-4 border border-yashil rounded-lg">
                <div class="text-2xl font-bold text-yashil mb-2">{{ round($result->score_communication) }}%</div>
                <div class="text-sm text-matn2">Muloqot</div>
            </div>
            <div class="text-center p-4 border-2 border-bosh rounded-lg bg-fon2">
                <div class="text-3xl font-bold text-matn mb-2">{{ round($result->score_average) }}%</div>
                <div class="text-sm text-matn2">O'rtacha</div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-base font-medium {{
                $result->risk_level === 'high' ? 'bg-red-500/20 text-red-400' : 
                ($result->risk_level === 'low' ? 'bg-green-500/20 text-green-400' : 
                'bg-yellow-500/20 text-yellow-400')
            }}">
                {{ $result->risk_emoji }} {{ $result->risk_label }}
            </span>
        </div>
    </div>

    <!-- JAVOBLAR -->
    <div class="bg-karta border border-chegara rounded-xl p-6">
        <h3 class="font-playfair text-lg text-matn mb-4">📋 Javoblar tafsilotlari</h3>
        
        @forelse($result->answers as $answer)
            <div class="mb-5 p-4 border border-chiziq rounded-lg">
                <div class="mb-3">
                    <strong class="text-matn">Savol {{ $loop->iteration }}:</strong>
                    <p class="mt-2 text-matn1">{{ $answer->question->question }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mb-3">
                    @foreach($answer->question->options as $option)
                        <div class="p-2 rounded-lg {{
                            $option->id === $answer->option_id ? 'bg-moviy text-white' : 'bg-fon2'
                        }}">
                            {{ $option->option_text }}
                            @if($option->id === $answer->question->correct_option_id)
                                <span class="ml-2">✅</span>
                            @endif
                            @if($option->id === $answer->option_id)
                                <span class="ml-2">👤</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="text-sm text-matn2">
                    To'g'ri javob: <span class="text-yashil font-bold">{{ $answer->question->correctOption->option_text ?? 'Noma\'lum' }}</span>
                    @if($answer->option_id === $answer->question->correct_option_id)
                        <span class="ml-3 text-yashil">✅ To'g'ri</span>
                    @else
                        <span class="ml-3 text-aksent">❌ Noto'g'ri</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-matn2">
                Javoblar topilmadi
            </div>
        @endforelse
    </div>

    <!-- AMALLAR -->
    <div class="flex gap-3 mt-6">
        <a href="{{ route('admin.results.index') }}" class="bg-fon3 hover:bg-fon2 text-matn px-4 py-2.5 rounded-lg transition-all duration-200">⬅️ Orqaga</a>
        <form action="{{ route('admin.results.destroy', $result) }}" method="POST"
              onsubmit="return confirm('Natijani o\'chirishga ishonchingiz komilmi?')">
            @csrf @method('DELETE')
            <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-2.5 rounded-lg transition-all duration-200">🗑️ O'chirish</button>
        </form>
    </div>
@endsection
