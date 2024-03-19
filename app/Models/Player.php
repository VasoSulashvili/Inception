<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Player extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "username",
        "first_name",
        "last_name",
        "gender",
        "lang",
        "email",
        "rank_id",
        "password",
        "balance",
        "is_blocked",
        'active',
        "deleted_at",
        "spinner_last_activity"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationships
     */
    public function prizes(): BelongsToMany
    {
        return $this->belongsToMany(
            Prize::class,
            'player_prize',
            'player_id',
            'prize_id'
        );
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class, 'rank_id');
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
}
