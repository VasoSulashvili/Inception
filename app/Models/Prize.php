<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prize extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'number' => 'integer',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'active'
    ];


    /**
     * Relationships
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'group_prize',
            'prize_id',
            'group_id'
        )->withPivot('number', 'amount');
    }


    public function winners(): BelongsToMany
    {
        return $this->belongsToMany(
            Player::class,
            'player_prize',
            'prize_id',
            'player_id'
        );
    }


    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'player_id', 'id');
    }


    /**
     * Scope a query.
     */
    public function scopeActive(Builder $query, $active = null): void
    {
        $query->where('active', ($active == null ? 1 : 0));
    }

    public function scopeIsWon(Builder $query, $isWon = null): void
    {
        if($isWon) {
            $query->where('won_at', '!=', null);
        } else {
            $query->where('won_at', '=', null);
        }
    }
}
