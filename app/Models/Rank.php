<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rank extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'rank',
        'name',
        'active'
    ];


    /**
     * Relationships
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function player(): HasOne
    {
        return $this->hasOne(Player::class, 'rank_id');
    }


    /**
     * Scope a query.
     */
    public function scopeActive(Builder $query, $active = null): void
    {
        $query->where('active', ($active == null ? 1 : 0));
    }

    public function scopeWinners(Builder $query): void
    {
        $query->where('rank', '<', 4);
    }

    public function scopeRunnerUps(Builder $query): void
    {
        $query->whereBetween('rank', [3, 9]);
    }

    public function scopeOthers(Builder $query): void
    {
        $query->where('rank', '>', 8);
    }
}
