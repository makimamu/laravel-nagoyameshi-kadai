<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('regular_holidays', function (Blueprint $table) {
        $table->id();
        $table->string('day'); // 曜日名や「不定休」などの文字列
        $table->integer('day_index')->nullable(); // カレンダー用の数値
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regular_holidays');
    }
};
