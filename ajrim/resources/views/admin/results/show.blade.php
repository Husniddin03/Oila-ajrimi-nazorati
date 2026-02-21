@extends('layouts.admin')
@section('title', 'Natija tafsilotlari')
@section('page-title', 'Natija tafsilotlari')

@section('content')
    <div class="section-sarlavha">
        <h2>📊 Test natijasi</h2>
        <div style="font-size:.82rem;color:var(--matn2);">
            {{ $result->user->name }} - {{ $result->test->title }}
        </div>
    </div>

    <!-- ASOSIY MA'LUMOTLAR -->
    <div class="karta" style="margin-bottom:20px;">
        <h3 style="margin-bottom:15px;">👤 Foydalanuvchi ma'lumotlari</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">
            <div>
                <strong>Ism:</strong><br>
                {{ $result->user->name }}
            </div>
            <div>
                <strong>Email:</strong><br>
                {{ $result->user->email }}
            </div>
            @if($result->user->phone)
                <div>
                    <strong>Telefon:</strong><br>
                    {{ $result->user->phone }}
                </div>
            @endif
            <div>
                <strong>Status:</strong><br>
                <span class="chip {{ $result->user->status === 'active' ? 'chip-yashil' : 'chip-qizil' }}">
                    {{ $result->user->status === 'active' ? '✅ Faol' : '❌ Bloklangan' }}
                </span>
            </div>
        </div>
    </div>

    <!-- TEST MA'LUMOTLARI -->
    <div class="karta" style="margin-bottom:20px;">
        <h3 style="margin-bottom:15px;">📝 Test ma'lumotlari</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;">
            <div>
                <strong>Test nomi:</strong><br>
                {{ $result->test->title }}
            </div>
            <div>
                <strong>Boshlanish vaqti:</strong><br>
                {{ $result->created_at->format('d.m.Y H:i') }}
            </div>
            <div>
                <strong>Tugash vaqti:</strong><br>
                {{ $result->completed_at->format('d.m.Y H:i') }}
            </div>
            <div>
                <strong> Sarflangan vaqt:</strong><br>
                {{ $result->completed_at->diffInMinutes($result->created_at) }} daqiqa
            </div>
        </div>
    </div>

    <!-- BALLAR -->
    <div class="karta" style="margin-bottom:20px;">
        <h3 style="margin-bottom:15px;">🎯 Ballar</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:15px;">
            <div style="text-align:center;padding:15px;border:1px solid var(--moviy);border-radius:8px;">
                <div style="font-size:1.5rem;font-weight:bold;color:var(--moviy);">
                    {{ round($result->score_emotional) }}%
                </div>
                <div style="font-size:.875rem;color:var(--matn2);">Emotsional</div>
            </div>
            <div style="text-align:center;padding:15px;border:1px solid var(--sariq);border-radius:8px;">
                <div style="font-size:1.5rem;font-weight:bold;color:var(--sariq);">
                    {{ round($result->score_financial) }}%
                </div>
                <div style="font-size:.875rem;color:var(--matn2);">Moliyaviy</div>
            </div>
            <div style="text-align:center;padding:15px;border:1px solid var(--yashil);border-radius:8px;">
                <div style="font-size:1.5rem;font-weight:bold;color:var(--yashil);">
                    {{ round($result->score_communication) }}%
                </div>
                <div style="font-size:.875rem;color:var(--matn2);">Muloqot</div>
            </div>
            <div style="text-align:center;padding:15px;border:2px solid var(--bosh);border-radius:8px;background:var(--fon2);">
                <div style="font-size:1.8rem;font-weight:bold;">
                    {{ round($result->score_average) }}%
                </div>
                <div style="font-size:.875rem;color:var(--matn2);">O'rtacha</div>
            </div>
        </div>
        
        <div style="margin-top:20px;text-align:center;">
            <span class="chip {{ $result->risk_level === 'high' ? 'chip-qizil' : ($result->risk_level === 'low' ? 'chip-yashil' : 'chip-sariq') }}"
                  style="font-size:1.1rem;padding:8px 16px;">
                {{ $result->risk_emoji }} {{ $result->risk_label }}
            </span>
        </div>
    </div>

    <!-- JAVOBLAR -->
    <div class="karta">
        <h3 style="margin-bottom:15px;">📋 Javoblar tafsilotlari</h3>
        
        @forelse($result->answers as $answer)
            <div style="margin-bottom:20px;padding:15px;border:1px solid var(--chiziq);border-radius:8px;">
                <div style="margin-bottom:10px;">
                    <strong>Savol {{ $loop->iteration }}:</strong>
                    <p style="margin:5px 0;color:var(--matn1);">{{ $answer->question->question }}</p>
                </div>
                
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px;">
                    @foreach($answer->question->options as $option)
                        <div style="padding:8px;border-radius:4px;{{ $option->id === $answer->option_id ? 'background:var(--moviy);color:white;' : 'background:var(--fon2);' }}">
                            {{ $option->option_text }}
                            @if($option->id === $answer->question->correct_option_id)
                                <span style="margin-left:5px;">✅</span>
                            @endif
                            @if($option->id === $answer->option_id)
                                <span style="margin-left:5px;">👤</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div style="margin-top:8px;font-size:.875rem;color:var(--matn2);">
                    To'g'ri javob: <span style="color:var(--yashil);font-weight:bold;">{{ $answer->question->correctOption->option_text ?? 'Noma\'lum' }}</span>
                    @if($answer->option_id === $answer->question->correct_option_id)
                        <span style="margin-left:10px;color:var(--yashil);">✅ To'g'ri</span>
                    @else
                        <span style="margin-left:10px;color:var(--qizil);">❌ Noto'g'ri</span>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:40px;color:var(--matn2);">
                Javoblar topilmadi
            </div>
        @endforelse
    </div>

    <!-- AMALLAR -->
    <div style="margin-top:20px;display:flex;gap:10px;">
        <a href="{{ route('admin.results.index') }}" class="btn btn-ikkinchi">⬅️ Orqaga</a>
        <form action="{{ route('admin.results.destroy', $result) }}" method="POST"
              onsubmit="return confirm('Natijani o\'chirishga ishonchingiz komilmi?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-xavf">🗑️ O'chirish</button>
        </form>
    </div>
@endsection
