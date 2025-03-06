<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('regular_holiday_restaurant', function (Blueprint $table) {
            $table->id(); // ID
            $table->foreignId('restaurant_id')
                ->constrained()
                ->cascadeOnDelete(); // 店舗が削除されたら関連データも削除

            $table->foreignId('regular_holiday_id')
                ->constrained()
                ->cascadeOnDelete(); // 定休日が削除されたら関連データも削除

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regular_holiday_restaurant');
    }
};