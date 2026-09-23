<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('admin_audit_logs', function(Blueprint $t){$t->id();$t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();$t->string('action',80);$t->string('entity_type',120)->nullable();$t->unsignedBigInteger('entity_id')->nullable();$t->json('metadata')->nullable();$t->string('ip_address',45)->nullable();$t->timestamps();$t->index(['entity_type','entity_id']);}); } public function down(): void { Schema::dropIfExists('admin_audit_logs'); } };
