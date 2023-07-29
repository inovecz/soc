<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discovery_batches', static function (Blueprint $table) {
            $table->id();
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });

        Schema::create('discovery_items', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('discovery_batch_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('host_id');
            $table->unsignedInteger('rule_id');
            $table->boolean('status')->default(false);
            $table->dateTime('last_up')->nullable();
            $table->dateTime('last_down')->nullable();
            $table->json('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discovery_items');
        Schema::dropIfExists('discovery_batches');
    }
};
