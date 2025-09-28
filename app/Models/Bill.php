<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'bill_category_id',
        'month',
        'year',
        'amount',
        'due_amount',
        'total_amount',
        'status',
        'due_date',
        'paid_date',
        'notes',
        'payment_details',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /**
     * Multi-tenant scope - only show bills for flats in buildings owned by current house owner
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

        // Automatically calculate total amount before creating/updating
        static::saving(function ($bill) {
            $bill->total_amount = $bill->amount + $bill->due_amount;
        });
    }

    /**
     * Get the flat this bill belongs to
     */
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    /**
     * Get the bill category
     */
    public function billCategory()
    {
        return $this->belongsTo(BillCategory::class);
    }

    /**
     * Check if bill is overdue
     */
    public function isOverdue()
    {
        return $this->status !== 'paid' && Carbon::now()->gt($this->due_date);
    }

    /**
     * Scope for overdue bills
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'paid')
                    ->where('due_date', '<', Carbon::now());
    }

    /**
     * Scope for unpaid bills
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    /**
     * Scope for paid bills
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope for admin to bypass multi-tenant restrictions
     */
    public function scopeWithoutHouseOwnerScope($query)
    {
        return $query->withoutGlobalScope('house_owner');
    }
}
