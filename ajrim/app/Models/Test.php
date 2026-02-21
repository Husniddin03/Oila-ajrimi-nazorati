<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'emoji',
        'color',
        'category',
        'duration_minutes',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static array $categories = [
        'muloqot'       => 'Muloqot muammolari',
        'moliyaviy'     => 'Moliyaviy kelishmovchilik',
        'emotsional'    => 'Emotsional munosabat',
        'bola_tarbiyasi'=> 'Bola tarbiyasi',
        'xiyonat'       => 'Xiyonat / ishonch',
        'xarakter'      => 'Xarakterlar mos kelmasligi',
        'moddiy'        => 'Moddiy muammolar',
        'zovravonlik'   => 'Zo\'ravonlik',
        'ichkilik'      => 'Ichkilikbozlik yoki giyohvandlik',
        'uzoq_yashasish'=> 'Uzoq vaqt alohida yashash',
        'qarindosh'     => 'Qaynona-qaynota muammolari',
        'majburiy_nikoh'=> 'Majburiy yoki shoshilinch nikoh',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::$categories[$this->category] ?? $this->category;
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function activeQuestions(): HasMany
    {
        return $this->hasMany(Question::class)->where('is_active', true)->orderBy('order');
    }

    public function results(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function getQuestionsCountAttribute(): int
    {
        return $this->questions()->count();
    }

    public function getCompletedCountAttribute(): int
    {
        return $this->results()->whereNotNull('completed_at')->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}