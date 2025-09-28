<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'name',
        'email',
        'phone',
        'permanent_address',
        'lease_start_date',
        'lease_end_date',
        'security_deposit',
        'emergency_contact',
        'is_active',
    ];

    protected $casts = [
        'lease_start_date' => 'date',
        'lease_end_date' => 'date',
        'security_deposit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Multi-tenant scope - only show tenants for flats in buildings owned by current house owner
     */
    protected static function booted()
    {
        static::addGlobalScope('house_owner', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role === 'house_owner') {
                $builder->whereHas('flat.building', function ($query) {
                    $query->where('house_owner_id', auth()->id());
                });
            }
        });
    }

    /**
     * Get the flat this tenant belongs to
     */
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    /**
     * Scope for admin to bypass multi-tenant restrictions
     */
    public function scopeWithoutHouseOwnerScope($query)
    {
        return $query->withoutGlobalScope('house_owner');
    }
}
