<?php

class Admin_Modul_Controller extends Base_Controller {

	public $restful = true;

    public function get_index(){
        return Redirect::to('admin/modul/application');
    }

    public function get_application(){

    	$flow = New Arcone;

        $data['struct'] = Menutree::generate();

    	return View::make('admin.modul.application',$data);

    }

    public function post_application(){

        $contents = Input::all();

        Admin_Modul::setPages($contents);

        return Redirect::to('admin/modul/application');

    }	

    public function get_register(){

        $structure = New Setup;

        $data['struct'] = $structure->populatemodul();

        return View::make('admin.modul.register',$data);

    }



}

?>