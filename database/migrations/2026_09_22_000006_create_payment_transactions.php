<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('payment_transactions', function(Blueprint $t){$t->id();$t->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();$t->string('gateway',40);$t->string('authority',120)->nullable()->index();$t->string('reference_id',120)->nullable()->index();$t->unsignedBigInteger('amount_toman');$t->string('status',30);$t->json('payload')->nullable();$t->timestamps();}); } public function down(): void { Schema::dropIfExists('payment_transactions'); } };
