<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = ['eatery_id', 'permit_no', 'expires_on'];

    protected function casts(): array
    {
        return [
            'expires_on' => 'date',
        ];
    }

    /** Expired when expires_on is before today (expiring today is still valid). */
    public function isExpired(): bool
    {
        return $this->expires_on->lt(today());
    }

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }
}
