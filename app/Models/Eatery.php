<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Eatery extends Model
{
    use HasFactory;

    protected $table = 'eateries';

    protected $fillable = [
        'district_id',
        'name',
        'slug',
        'address',
        'price_range',
        'specialty',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    /** Implicit route model binding uses the slug: /eateries/{slug}. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Everything an <x-eatery-card> needs, loaded up front so the card
     * never lazy-loads inside a @foreach (avoids N+1).
     */
    public function scopeWithCardData(Builder $query): Builder
    {
        return $query
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');
    }

    /** budget / mid / splurge  ->  ₱ / ₱₱ / ₱₱₱ */
    protected function priceSymbol(): Attribute
    {
        return Attribute::get(fn (): string => match ($this->price_range) {
            'budget' => '₱',
            'mid' => '₱₱',
            'splurge' => '₱₱₱',
            default => '',
        });
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function permit(): HasOne
    {
        return $this->hasOne(Permit::class);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
