<?php
/*********************************************************************
*  Module : Admin
*  Controller : Module
*  Function : 
*  Author :  joharijumali
*  Description: Class for Modul Management Module
**********************************************************************/

class Admin_Modul_Controller extends Base_Controller {

	public $restful = true;

    public function get_index(){
        return Redirect::to('admin/modul/application');
    }

    /**
     * application RESTful function
     * Setup pages
     * @return view
     * @author joharijumali
     **/

    public function get_application(){

    	$flow = New Arcone;

        $data['struct'] = Menutree::generate();

    	return View::make('admin.modul.application',$data);

    }

    public function post_application(){

        $contents = Input::all();

        Admin_ModulPage::setPages($contents);

        return Redirect::to('admin/modul/application');

    }	

    /**
     * register RESTful function
     * Setup modul
     * @return view
     * @author joharijumali
     **/

    public function get_register(){

        $structure = New Setup;

        $data['struct'] = $structure->populatemodul();

        return View::make('admin.modul.register',$data);

    }



}

?>