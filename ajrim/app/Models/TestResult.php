<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'score_emotional',
        'score_financial',
        'score_communication',
        'score_average',
        'risk_level',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'score_emotional' => 'decimal:2',
        'score_financial' => 'decimal:2',
        'score_communication' => 'decimal:2',
        'score_average' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }

    public function getRiskLabelAttribute(): string
    {
        return match($this->risk_level) {
            'high'   => 'Yuqori xavf',
            'low'    => 'Past xavf',
            default  => "O'rta xavf",
        };
    }

    public function getRiskColorAttribute(): string
    {
        return match($this->risk_level) {
            'high'   => '#e94560',
            'low'    => '#3fb950',
            default  => '#d29922',
        };
    }

    public function getRiskEmojiAttribute(): string
    {
        return match($this->risk_level) {
            'high'  => '🔴',
            'low'   => '🟢',
            default => '🟡',
        };
    }

    // Calculate risk level from average score (0-100%)
    public static function calculateRisk(float $avgPercent): string
    {
        if ($avgPercent >= 70) return 'low';
        if ($avgPercent >= 40) return 'medium';
        return 'high';
    }
}