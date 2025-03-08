<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 会社名
            $table->string('postal_code'); // 郵便番号
            $table->string('address'); // 所在地
            $table->string('representative'); // 代表者
            $table->date('establishment_date'); // 設立年月日
            $table->string('capital'); // 資本金
            $table->string('business'); // 事業内容
            $table->string('number_of_employees'); // 従業員数
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('companies');
    }
};