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
    Schema::create('regular_holiday_restaurant', function (Blueprint $table) {
        $table->id();
        $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();  // 外部キー制約
        $table->foreignId('regular_holiday_id')->constrained()->cascadeOnDelete();  // 外部キー制約
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regular_holiday_restaurant');
    }
};
