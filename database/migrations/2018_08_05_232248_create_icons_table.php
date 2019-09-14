<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateIconsTable.
 */
class CreateIconsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(!Schema::hasTable('icons')) {
            Schema::create('icons', function(Blueprint $table) {
                $table->increments('id');
                $table->string('unicode')->nullable()->comment('unicode 字符');
                $table->string('class')->nullable()->comment('类名');
                $table->string('name')->nullable()->comment('名称');
                $table->integer('sort')->default(0)->comment('排序');
                $table->timestamps();
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('icons');
	}
}
