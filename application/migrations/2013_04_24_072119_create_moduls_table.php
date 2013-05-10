<?php

class Create_Moduls_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modul_pages', function($table) {

		    $table->increments('modulpageid');
		    $table->string('modul', 100);
		    $table->integer('modulid');
		    $table->string('controller', 100);
		    $table->string('controlleralias', 100);
		    $table->string('action', 100);
		    $table->string('actionalias', 100);
		    $table->integer('visible');
		    $table->integer('header');
		    $table->integer('footer');
		    $table->integer('auth');
		    $table->integer('admin');
		    $table->integer('arrangement');
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
		Schema::drop('modul_pages');
	}

}