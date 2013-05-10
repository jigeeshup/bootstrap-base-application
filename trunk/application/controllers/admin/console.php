<?php

/*********************************************************************
*  Module : Admin
*  Controller : Console
*  Function : 
*  Author :  joharijumali
*  Description: Class for System Management Module
**********************************************************************/



class Admin_Console_Controller extends Base_Controller {

	public $restful = true;

    public function get_index(){
        return Redirect::to('admin/console/menu');
    }

	/**
	 * menu RESTful function
	 *
	 * @return view
	 * @author joharijumali
	 **/

	public function get_menu()
	{

		$data['render'] = Menutree::navTree();
		$data['headerlist'] = $list = Admin_Nav::listheader();
		$data['page'] = $listpage = Admin_ModulPage::listpages();
		$data['pagelist'] = $listpage = Admin_ModulPage::listAvailpages();

		return View::make('admin.console.menu',$data);

	}

	public function post_menu()
	{

		$contents = Input::get();

		foreach ($contents['module'] as $key => $value) {
			$module = Admin_Nav::find($value);
	        $module->step  = $key+1;
	        $module->save();
		}

		foreach ($contents['parent'] as $key => $value) {
			$module = Admin_Navpage::find($value);
	        $module->parentstep  = $key+1;
	        $module->save();
		}

		return Redirect::to('admin/console/menu');
	}

	/**
	 * navigation utilities function
	 *
	 * @return json data
	 * 
	 **/

	public function get_navchild(){

		$input = Input::get();

        $navigation = Admin_Navpage::find($input['navid']);
        $nav = Admin_Nav::find($navigation->navheaderid);
        $parent = Admin_ModulPage::find($navigation->modulpageid);

        $data['navheaderid'] = $navigation->navheaderid;
        $data['module'] = $nav->navheader;
        $data['parentid'] = $navigation->navpageid;
        $data['parent'] = $parent->actionalias;

        return json_encode($data);
	}

	public function get_resetnavdata(){

		$data['navheaderid'] = $list = Admin_Nav::listheader();
		// $data['page'] = $listpage = Admin_ModulPage::listpages();
		$data['modulpageid'] = $listpage = Admin_ModulPage::listAvailpages();

		return json_encode($data);

	}

	public function post_setmodule(){
		
		$input = Input::get();

		// if($input['roleid'] == NULL):
		$module = new Admin_Nav;
		// else:
		// 	$role = Admin_UserRole::find($input['roleid']);
		// endif;
        $module->navheader  = $input['navheader'];
        $module->save();

		return Menutree::navTree();
	}

	public function post_setpage(){
		
		$input = Input::get();

		// if($input['roleid'] == NULL):
		$pages = new Admin_Navpage;
		// else:
		// 	$role = Admin_UserRole::find($input['roleid']);
		// endif;
        $pages->navheaderid  = $input['navheaderid'];
        $pages->modulpageid  = $input['modulpageid'];
        $pages->save();

		return Menutree::navTree();
	}

	public function post_setchild(){

		$input = Input::get();

				// if($input['roleid'] == NULL):
		$pages = new Admin_Navpage;
		// else:
		// 	$role = Admin_UserRole::find($input['roleid']);
		// endif;
        $pages->navheaderid  = $input['navheaderid'];
        $pages->parentid  = $input['parentid'];
        $pages->modulpageid  = $input['modulpageid'];
        $pages->save();

		return Menutree::navTree();
	}

    public function post_deletepages(){
        
        $input = Input::get();

        Admin_Navpage::find($input['id'])->delete();

        return Menutree::navTree();
    }

    public function post_deletemodule(){
        
        $input = Input::get();

        Admin_Nav::find($input['id'])->delete();
        Admin_Navpage::where('navheaderid','=',$input['id'])->delete();

        return Menutree::navTree();
    }


	/**
	 * ACL RESTful function
	 *
	 * @return view
	 * @author joharijumali
	 * 
	 **/

	public function get_acl(){

		$data['rolelist'] = Admin_UserRole::all();
		$data['page'] = Admin_Menu::pageExist();//all();

		$data['acl'] = Admin_UserAcl::aclRegistered();
		$data['acree'] = Acltree::render();


		return View::make('admin.console.acl',$data);
	}

	public function post_acl(){

		$input = Input::get();

		foreach($input as $role => $content){

			$role = Admin_UserRole::find($content['id']);

			$role->acl()->delete();

			unset($content['id']);

			foreach($content as $controler => $action){
				
				$mem = array_keys($action);

				foreach($mem as $mempage){
					$pages = array(
					    array('controller' => $controler,'action' => $mempage)
					);

					if(!empty($action)){
						$role->acl()->save($pages);
					}
				}
			}
		}

		return Redirect::to('admin/console/acl');
	}

	public function get_logger(){


		$data['files'] = '';//Logger::get_files(); 

		return View::make('admin.console.logger',$data);

	}



}

?>