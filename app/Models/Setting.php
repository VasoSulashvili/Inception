<?php

namespace App\Models;

use App\Support\Facades\CacheService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'value',
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
            CacheService::destroySettings();
        });

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::updated(function($item) {
            CacheService::destroySettings();
        });
        /**
         * Write code on Method
         *
         * @return response()
         */
        static::deleted(function($item) {
            CacheService::destroySettings();
        });
    }


    /**
     * Scope a query.
     */
    public function scopeActive(Builder $query, $active = null): void
    {
        $query->where('active', ($active == null ? 1 : 0));
    }
}
