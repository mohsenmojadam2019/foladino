<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile', 20)->nullable()->unique()->after('email');
            $table->string('company_name')->nullable()->after('mobile');
            $table->string('national_id', 20)->nullable()->after('company_name');
            $table->string('economic_code', 20)->nullable()->after('national_id');
            $table->text('default_address')->nullable()->after('economic_code');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('order_number', 30)->nullable()->unique()->after('public_token');
            $table->unsignedBigInteger('subtotal_toman')->default(0)->after('total_toman');
            $table->unsignedBigInteger('shipping_toman')->default(0)->after('subtotal_toman');
            $table->unsignedInteger('total_weight_kg')->default(0)->after('shipping_toman');
            $table->string('loading_city')->nullable()->after('city');
            $table->string('delivery_method', 30)->default('delivery')->after('loading_city');
            $table->date('estimated_delivery_date')->nullable()->after('delivery_method');
            $table->unsignedTinyInteger('deposit_percent')->default(100)->after('estimated_delivery_date');
            $table->string('invoice_type', 20)->default('personal')->after('deposit_percent');
            $table->text('delivery_address')->nullable()->after('invoice_type');
            $table->text('admin_note')->nullable()->after('delivery_address');
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->string('product_name');
            $table->string('sku')->nullable();
            $table->decimal('quantity_tons', 10, 2);
            $table->unsignedBigInteger('unit_price_toman');
            $table->unsignedBigInteger('line_total_toman');
            $table->unsignedInteger('weight_kg')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id','order_number','subtotal_toman','shipping_toman','total_weight_kg','loading_city','delivery_method','estimated_delivery_date','deposit_percent','invoice_type','delivery_address','admin_note']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['mobile']);
            $table->dropColumn(['mobile','company_name','national_id','economic_code','default_address']);
        });
    }
};
