<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorklogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('worklogs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('job_id')->unsigned();
			$table->text('notes');
			$table->timestamp('begin_at')->nullable();
			$table->timestamp('end_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
		 });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('worklogs');
	}
}
