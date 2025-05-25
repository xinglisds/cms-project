<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'target_url',
        'position',
        'active_from',
        'active_to',
    ];

    protected $casts = [
        'active_from' => 'datetime',
        'active_to' => 'datetime',
    ];

    /**
     * Scope for active ads based on current date
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('active_from', '<=', $now)
                    ->where('active_to', '>=', $now);
    }

    /**
     * Scope for ads by position
     */
    public function scopeByPosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Check if ad is currently active
     */
    public function isActive(): bool
    {
        $now = Carbon::now();
        return $this->active_from <= $now && $this->active_to >= $now;
    }
}
