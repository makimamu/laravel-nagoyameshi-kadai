<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurants extends Migration
{
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('name'); // 店舗名
            $table->string('image')->default(''); // 店舗画像
            $table->text('description'); // 説明
            $table->integer('lowest_price')->unsigned(); // 最低価格
            $table->integer('highest_price')->unsigned(); // 最高価格
            $table->string('postal_code'); // 郵便番号
            $table->string('address'); // 住所
            $table->time('opening_time'); // 開店時間
            $table->time('closing_time'); // 閉店時間
            $table->integer('seating_capacity')->unsigned(); // 座席数
            $table->timestamps(); // 作成日時・更新日時
            //$table->string('image_name')->nullable();// image_nameカラムを設定する
});
}

    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
