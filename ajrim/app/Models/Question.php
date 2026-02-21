<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question_text',
        'question_type',
        'order',
        'category_tag',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }

    // Default scale options (1-5)
    public function getScaleOptionsAttribute(): array
    {
        return [
            ['value' => 1, 'label' => 'Umuman yo\'q'],
            ['value' => 2, 'label' => 'Kamdan-kam'],
            ['value' => 3, 'label' => 'Ba\'zan'],
            ['value' => 4, 'label' => 'Tez-tez'],
            ['value' => 5, 'label' => 'Har doim'],
        ];
    }
}