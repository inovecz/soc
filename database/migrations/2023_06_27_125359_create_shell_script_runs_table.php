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
        Schema::create('shell_script_runs', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('shell_script_id')->constrained();
            $table->text('script');
            $table->enum('state', ['PENDING', 'RUNNING', 'FINISHED', 'FAILED'])->default('PENDING');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->text('output')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shell_script_runs');
    }
};
