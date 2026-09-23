<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Vehicle extends Model {protected $guarded=[]; protected function casts():array{return ['is_active'=>'boolean'];} public function shipments(){return $this->hasMany(Shipment::class);} }
