<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable()->comment('验证码');
            $table->string('phone')->nullable()->comment('手机号');
            $table->tinyInteger('is_use')->nullable()->default(0)->comment('是否使用:0未使用,1已使用');
            $table->tinyInteger('type')->nullable()->default(0)->comment('1-后端 2-客户端 3-商户端');
            $table->index('phone');
            $table->index('is_use');
            $table->index('type');
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
        Schema::dropIfExists('phone_codes');
    }
}
