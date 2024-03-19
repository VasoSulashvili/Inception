<?php

namespace App\Models;

use App\Support\Facades\CacheService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'active'
    ];

    public static function boot() {
        parent::boot();

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::created(function($item) {
            CacheService::destroyGroups();
        });

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::updated(function($item) {
            CacheService::destroyGroups();
        });
        /**
         * Write code on Method
         *
         * @return response()
         */
        static::deleted(function($item) {
            CacheService::destroyGroups();
        });
    }

    /**
     * Relationships
     */
    public function ranks() : HasMany
    {
        return $this->hasMany(Rank::class, 'group_id', 'id');
    }

    public function prizes(): BelongsToMany
    {
        return $this->belongsToMany(
            Prize::class,
            'group_prize',
            'group_id',
            'prize_id'
        )->withPivot('number', 'amount');
    }

    /**
     * Scope a query.
     */
    public function scopeActive(Builder $query, $active = null): void
    {
        $query->where('active', ($active == null ? 1 : 0));
    }
}
