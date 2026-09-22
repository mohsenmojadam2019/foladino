<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::table('purchase_orders', function (Blueprint $t) { $t->string('reference_id', 100)->nullable()->index(); $t->timestamp('paid_at')->nullable(); $t->json('gateway_payload')->nullable(); }); } public function down(): void { Schema::table('purchase_orders', function (Blueprint $t) { $t->dropColumn(['reference_id','paid_at','gateway_payload']); }); } };
