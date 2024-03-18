<?php

namespace App\Models;

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
}
