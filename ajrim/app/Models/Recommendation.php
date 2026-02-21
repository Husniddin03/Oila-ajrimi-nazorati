<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'color',
        'risk_level',
        'category',
        'tags',
        'is_active',
        'order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForRisk($query, string $riskLevel)
    {
        return $query->where(function ($q) use ($riskLevel) {
            $q->where('risk_level', $riskLevel)
              ->orWhere('risk_level', 'all');
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}