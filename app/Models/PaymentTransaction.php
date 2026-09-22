<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PaymentTransaction extends Model { protected $guarded=[]; protected function casts(): array { return ['payload'=>'array']; } public function order(){ return $this->belongsTo(PurchaseOrder::class,'purchase_order_id'); } }
