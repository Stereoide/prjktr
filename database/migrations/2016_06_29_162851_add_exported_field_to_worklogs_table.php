<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExportedFieldToWorklogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('worklogs', function ($table) {
			$table->boolean('is_exported')->default(false);
			$table->timestamp('exported_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('worklogs', function ($table) {
			$table->dropColumn('is_exported');
			$table->dropColumn('exported_at');
		});
	}
}
