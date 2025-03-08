<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // 利用規約の本文
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('terms');
    }
};