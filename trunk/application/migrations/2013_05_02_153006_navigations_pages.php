<?php

class Navigations_Pages {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation_pages', function($table) {

		    $table->increments('navpageid');
		    $table->timestamps();
		    $table->integer('navheaderid');
		    $table->integer('parentid');
		    $table->integer('modulpageid');

		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navigation_pages');
	}

}