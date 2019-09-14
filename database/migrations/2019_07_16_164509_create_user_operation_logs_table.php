<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserOperationLogsTable.
 */
class CreateUserOperationLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_operation_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('path')->comment('请求路径');
            $table->string('method')->comment('请求方法');
            $table->string('ip')->comment('请求ip');
            $table->text('input')->comment('请求的内容');
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
		Schema::drop('user_operation_logs');
	}
}
