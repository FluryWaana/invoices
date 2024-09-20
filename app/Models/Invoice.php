<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer',
        'number',
        'status',
        'sent_at',
        'paid_at',
        'internal_note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => InvoiceStatus::class,
    ];

    /**
     * Get the lines for the invoice.
     */
    public function invoiceLines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    /**
     * Get the total amount for the invoice.
     */
    public function getTotalAttribute(): float
    {
        return $this->invoiceLines->sum('amount');
    }
}
