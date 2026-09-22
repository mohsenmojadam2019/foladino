<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('products', function(Blueprint $t){$t->unsignedBigInteger('stock_kg')->default(0)->after('price');$t->decimal('min_order_tons',10,2)->default(1)->after('stock_kg');$t->string('loading_city')->nullable()->after('min_order_tons');$t->unsignedSmallInteger('lead_time_days')->default(2)->after('loading_city');});
        Schema::create('shipping_rates', function(Blueprint $t){$t->id();$t->string('origin_city');$t->string('destination_city');$t->unsignedInteger('min_weight_kg')->default(0);$t->unsignedInteger('max_weight_kg')->nullable();$t->unsignedBigInteger('base_price_toman');$t->unsignedBigInteger('price_per_kg_toman')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();$t->index(['origin_city','destination_city']);});
    }
    public function down(): void { Schema::dropIfExists('shipping_rates'); Schema::table('products',function(Blueprint $t){$t->dropColumn(['stock_kg','min_order_tons','loading_city','lead_time_days']);}); }
};
