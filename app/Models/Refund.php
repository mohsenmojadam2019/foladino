<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Refund extends Model { protected $guarded=[]; protected function casts(): array{return ['processed_at'=>'datetime'];} public function order(){return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');} public function transaction(){return $this->belongsTo(PaymentTransaction::class,'payment_transaction_id');} }
