<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BillCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_owner_id',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Multi-tenant scope - only show bill categories for current house owner
     */
    protected static function booted()
    {
        static::addGlobalScope('house_owner', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role === 'house_owner') {
                $builder->where('house_owner_id', auth()->id());
            }
        });
    }

    /**
     * Get the house owner that created this bill category
     */
    public function houseOwner()
    {
        return $this->belongsTo(User::class, 'house_owner_id');
    }

    /**
     * Get all bills using this category
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
