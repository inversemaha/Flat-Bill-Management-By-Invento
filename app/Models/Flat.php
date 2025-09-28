<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Flat extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'flat_number',
        'floor',
        'bedrooms',
        'bathrooms',
        'rent_amount',
        'area_sqft',
        'owner_name',
        'owner_phone',
        'owner_email',
        'owner_address',
        'is_occupied',
    ];

    protected $casts = [
        'floor' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'rent_amount' => 'decimal:2',
        'area_sqft' => 'decimal:2',
        'is_occupied' => 'boolean',
    ];

    /**
     * Multi-tenant scope - only show flats for buildings owned by current house owner
     */
    protected static function booted()
    {
        static::addGlobalScope('house_owner', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role === 'house_owner') {
                $builder->whereHas('building', function ($query) {
                    $query->where('house_owner_id', auth()->id());
                });
            }
        });
    }

    /**
     * Get the building this flat belongs to
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the tenant currently occupying this flat
     */
    public function tenant()
    {
        return $this->hasOne(Tenant::class)->where('is_active', true);
    }

    /**
     * Get all tenants (including past ones) for this flat
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Get all bills for this flat
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Scope for admin to bypass multi-tenant restrictions
     */
    public function scopeWithoutHouseOwnerScope($query)
    {
        return $query->withoutGlobalScope('house_owner');
    }
}
