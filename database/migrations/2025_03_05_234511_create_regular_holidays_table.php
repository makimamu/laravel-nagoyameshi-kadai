<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('regular_holidays', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('day'); // 定休日（曜日や不定休）
            $table->integer('day_index')->nullable(); // 定休日の番号（NULL許容）
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regular_holidays');
    }
};