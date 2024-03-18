<?php

namespace App\Models;

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


    /**
     * Scope a query.
     */
    public function scopeActive(Builder $query, $active = null): void
    {
        $query->where('active', ($active == null ? 1 : 0));
    }
}
