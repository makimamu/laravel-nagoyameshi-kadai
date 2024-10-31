<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //マイグレーションの実行時にはup()メソッドの処理が行われるので、テーブルに必要なカラムなどはup()メソッド内に記述.
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('name'); // ユーザー名（漢字）
            $table->string('kana'); // ユーザー名（フリガナ）
            $table->string('email')->unique(); // メールアドレス（ユニークキー）
            $table->timestamp('email_verified_at')->nullable(); // メールアドレス認証の完了・未完了
            $table->string('password'); // パスワード
            $table->string('postal_code'); // 郵便番号
            $table->string('address'); // 住所
            $table->string('phone_number'); // 電話番号
            $table->date('birthday')->nullable(); // 生年月日（NULLを許容）
            $table->string('occupation')->nullable(); // 職業（NULLを許容）
            $table->rememberToken(); // ログイン状態を保持するためのトークン
            $table->timestamps(); // 作成日時と更新日時
        });
    }

    /**
     * Reverse the migrations.
     */

    //down()メソッド内にはロールバック時の処理を記述。
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
