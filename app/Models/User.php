<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'address',
        'last_login_at',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is house owner
     */
    public function isHouseOwner(): bool
    {
        return $this->role === 'house_owner';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if user is tenant role
     */
    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }

    /**
     * Get buildings owned by this house owner
     */
    public function buildings()
    {
        return $this->hasMany(Building::class, 'house_owner_id');
    }

    /**
     * Get bill categories created by this house owner
     */
    public function billCategories()
    {
        return $this->hasMany(BillCategory::class, 'house_owner_id');
    }
}
