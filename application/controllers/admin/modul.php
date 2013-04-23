<?php

class Admin_Modul_Controller extends Base_Controller {

	public $restful = true;

    public function get_index(){
        return Redirect::to('admin/modul/application');
    }

    public function get_application(){

    	return View::make('admin.modul.application');

    }	

}

?>