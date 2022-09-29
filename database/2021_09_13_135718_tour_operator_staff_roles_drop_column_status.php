<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TourOperatorStaffRolesDropColumnStatus extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('tour_operator_staff_roles', function(Blueprint $table) {
			$table->dropColumn('status');
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::table('tour_operator_staff_roles', function(Blueprint $table) {
			$table->enum('status', [ 'Inactive', 'Active' ])->default('Active')->after('tour_operator_staff_id');
		});
	}
}
