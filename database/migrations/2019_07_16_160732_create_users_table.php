<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->comment('头像');
            $table->integer('phone')->comment('电话');
            $table->string('password')->comment('密码');
            $table->string('balance')->comment('余额');
            $table->integer('state')->comment('状态 1 带激活 2 正常 3 锁定');
            $table->string('service')->comment('客服');
            $table->string('top_time')->comment('上次登陆时间');
            $table->string('Superior')->comment('上级推广员');
            $table->string('Superior_phone')->comment('上级电话');
            $table->string('subordinate_number')->comment('下级用户数量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
