<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    protected $guarded=[];
    protected function casts(): array { return ['price'=>'decimal:0','price_change'=>'decimal:2','stock_kg'=>'integer','min_order_tons'=>'decimal:2','lead_time_days'=>'integer','is_featured'=>'boolean','is_active'=>'boolean']; }
    public function category(){ return $this->belongsTo(Category::class); }
    public function factory(){ return $this->belongsTo(Factory::class); }
    public function prices(){ return $this->hasMany(PriceHistory::class); }
}
