<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('email')->unique(); $t->timestamp('email_verified_at')->nullable();
            $t->string('password'); $t->enum('role',['super_admin','admin','pricing','content'])->default('admin');
            $t->boolean('is_active')->default(true); $t->timestamp('last_login_at')->nullable(); $t->rememberToken(); $t->timestamps();
        });
        Schema::create('categories', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('slug')->unique(); $t->string('icon')->nullable(); $t->unsignedInteger('sort_order')->default(0); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('factories', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('slug')->unique(); $t->string('province')->nullable(); $t->string('city')->nullable(); $t->string('logo')->nullable(); $t->string('phone')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('products', function (Blueprint $t) {
            $t->id(); $t->foreignId('category_id')->constrained()->cascadeOnDelete(); $t->foreignId('factory_id')->nullable()->constrained()->nullOnDelete();
            $t->string('name'); $t->string('slug')->unique(); $t->string('sku')->unique(); $t->string('unit')->default('کیلوگرم'); $t->string('size')->nullable(); $t->string('standard')->nullable();
            $t->unsignedBigInteger('price')->default(0); $t->decimal('price_change',6,2)->default(0); $t->enum('stock_status',['available','call','unavailable'])->default('available');
            $t->string('image')->nullable(); $t->text('description')->nullable(); $t->boolean('is_featured')->default(false); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('price_histories', function (Blueprint $t) {
            $t->id(); $t->foreignId('product_id')->constrained()->cascadeOnDelete(); $t->unsignedBigInteger('price'); $t->decimal('change_percent',6,2)->default(0); $t->timestamp('recorded_at'); $t->timestamps();
        });
        Schema::create('quote_requests', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('mobile',20); $t->string('product_name')->nullable(); $t->decimal('amount',10,2)->nullable(); $t->string('city')->nullable();
            $t->enum('status',['new','contacted','quoted','won','lost'])->default('new'); $t->text('note')->nullable(); $t->timestamps();
        });
        Schema::create('articles', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('slug')->unique(); $t->string('excerpt',500)->nullable(); $t->text('body')->nullable(); $t->string('image')->nullable();
            $t->timestamp('published_at')->nullable(); $t->boolean('is_published')->default(true); $t->timestamps();
        });
        Schema::create('testimonials', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('role')->nullable(); $t->string('company')->nullable(); $t->text('quote'); $t->string('avatar')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps();
        });
        Schema::create('settings', function (Blueprint $t) { $t->id(); $t->string('key')->unique(); $t->text('value')->nullable(); $t->string('group')->default('general'); });
    }
    public function down(): void
    {
        Schema::dropIfExists('settings'); Schema::dropIfExists('testimonials'); Schema::dropIfExists('articles'); Schema::dropIfExists('quote_requests'); Schema::dropIfExists('price_histories'); Schema::dropIfExists('products'); Schema::dropIfExists('factories'); Schema::dropIfExists('categories'); Schema::dropIfExists('users');
    }
};
