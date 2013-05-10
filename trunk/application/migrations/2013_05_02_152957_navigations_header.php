<?php

class Navigations_Header {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation_headers', function($table) {

		    $table->increments('navheaderid');
		    $table->string('navheader', 100);
		    $table->integer('step');
		    $table->timestamps();

		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navigation_headers');
	}

}