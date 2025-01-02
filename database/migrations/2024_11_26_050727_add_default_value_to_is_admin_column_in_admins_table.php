<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToIsAdminColumnInAdminsTable extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->change(); // デフォルト値を設定
        });
    }
    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('is_admin')->default(null)->change(); // 変更を元に戻す
        });
    }
}
