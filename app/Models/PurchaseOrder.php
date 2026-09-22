<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity_tons' => 'decimal:2',
            'paid_at' => 'datetime',
            'gateway_payload' => 'array',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions() { return $this->hasMany(PaymentTransaction::class); }
}
