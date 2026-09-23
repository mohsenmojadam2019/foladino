<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Shipment extends Model {protected $guarded=[]; protected function casts():array{return ['loaded_at'=>'datetime','delivered_at'=>'datetime'];} public function order(){return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');} public function vehicle(){return $this->belongsTo(Vehicle::class);} }
