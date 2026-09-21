<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $t) {
            $t->id();
            $t->uuid('public_token')->unique();
            $t->foreignId('product_id')->constrained()->restrictOnDelete();
            $t->string('customer_name', 120);
            $t->string('mobile', 20);
            $t->string('city', 100)->nullable();
            $t->decimal('quantity_tons', 10, 2);
            $t->unsignedBigInteger('unit_price_toman');
            $t->unsignedBigInteger('total_toman');
            $t->string('status', 30)->default('pending');
            $t->string('gateway', 30)->default('zarinpal');
            $t->string('authority', 80)->nullable()->index();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
