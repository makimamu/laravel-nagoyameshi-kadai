<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();// IDカラム
            $table->string('name');//ユーザー名(漢字)
            $table->string('kana');//ユーザー名(ふりがな)
            $table->string('email')->unique(); // メールアドレス（ユニーク）
            $table->timestamp('email_verified_at')->nullable(); // メールアドレス認証（nullable）
            $table->string('password'); // パスワード
            $table->string('postal_code'); // 郵便番号
            $table->string('address'); // 住所
            $table->string('phone_number'); // 電話番号
            $table->date('birthday')->nullable(); // 生年月日（nullable）
            $table->string('occupation')->nullable(); // 職業（nullable）
            $table->rememberToken(); // ログイン状態を保持するトークン
            $table->timestamps(); // 作成日時、更新日時 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
