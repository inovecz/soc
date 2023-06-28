<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shell_scripts', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['TEMPLATE', 'SCRIPT'])->default('SCRIPT');
            $table->foreignId('template_id')->nullable()->references('id')->on('shell_scripts')->onDelete('set null');
            $table->text('script');
            $table->json('parameters')->nullable();
            $table->json('values')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shell_scripts');
    }
};
