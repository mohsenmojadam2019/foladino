<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PriceHistory extends Model { protected $guarded=[]; protected function casts(): array { return ['recorded_at'=>'datetime','price'=>'decimal:0','change_percent'=>'decimal:2']; } public function product(){return $this->belongsTo(Product::class);} }
