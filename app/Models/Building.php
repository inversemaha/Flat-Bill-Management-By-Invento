<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_owner_id',
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'total_floors',
        'description',
    ];

    protected $casts = [
        'total_floors' => 'integer',
    ];

    /**
     * Multi-tenant scope - only show buildings for current house owner
     */
    protected static function booted()
    {
        static::addGlobalScope('house_owner', function (Builder $builder) {
            if (auth()->check() && auth()->user()->isHouseOwner()) {
                $builder->where('house_owner_id', auth()->id());
            }
        });
    }

    /**
     * Get the house owner that owns this building
     */
    public function houseOwner()
    {
        return $this->belongsTo(User::class, 'house_owner_id');
    }

    /**
     * Get all flats in this building
     */
    public function flats()
    {
        return $this->hasMany(Flat::class);
    }

    /**
     * Get all tenants in this building (through flats)
     */
    public function tenants()
    {
        return $this->hasManyThrough(Tenant::class, Flat::class);
    }

    /**
     * Scope for admin to bypass multi-tenant restrictions
     */
    public function scopeWithoutHouseOwnerScope($query)
    {
        return $query->withoutGlobalScope('house_owner');
    }
}
