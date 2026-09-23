<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('admin_notifications',function(Blueprint $t){$t->id();$t->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();$t->string('title');$t->text('body')->nullable();$t->string('type',30)->default('info');$t->string('link')->nullable();$t->timestamp('read_at')->nullable();$t->timestamps();$t->index(['user_id','read_at']);}); } public function down(): void { Schema::dropIfExists('admin_notifications'); } };
