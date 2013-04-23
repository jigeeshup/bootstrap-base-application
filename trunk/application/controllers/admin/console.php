<?php

class Admin_Console_Controller extends Base_Controller {

	public $restful = true;

    public function get_index(){
        return Redirect::to('admin/console/menu');
    }

	//get info on the current created menu
	public function get_menu()
	{


		$data['pageExist'] = Admin_Menu::pageAccesible();
		$data['selected'] = Menutree::dataTree();
		$data['navigation'] = Menutree::fileTree();
		$data['render'] = Menutree::render();

		return View::make('admin.console.menu',$data);

	}

	public function post_menu()
	{

		$contents = Input::get();

		$ctrlArrangment = count($contents) + 1;

		foreach ($contents as $packet => $folder) {
			foreach ($folder as $controller => $field) {

			if(isset($field['alias']) && $field['alias'] != NULL && (isset($field['header']) || isset($field['footer']) || isset($field['id']))):

				if($field['id'] == 0):
					$menu = new Admin_Menu();
				else:
					$menu = Admin_Menu::find($field['id']);
				endif;
				
				$menu->controller = $packet.'/'.$controller;
				$menu->controllerAlias = $field['alias'];
				$menu->header = (isset($field['header']) && $field['header']=='on')?1:0;
				$menu->footer = (isset($field['footer']) && $field['footer']=='on')?1:0;
				$menu->auth = (isset($field['auth']) && $field['auth']=='on')?1:0;
				$menu->admin = (isset($field['admin']) && $field['admin']=='on')?1:0;
				$menu->arrangement = isset($field['arr'])?$field['arr']:$ctrlArrangment;
				$menu->save();

				$isAdmin = (isset($field['admin']) && $field['admin'] == 'on')?1:0;

				unset($field['alias']);
				unset($field['header']);
				unset($field['footer']);
				unset($field['auth']);
				unset($field['arr']);
				unset($field['id']);
				unset($field['admin']);

				$actionArrangment = count($field) + 1;

				foreach ($field as $action => $actionVal) {

					if($actionVal['id'] == 0):
						$subMenu = new Admin_Menu();
					else:
						$subMenu = Admin_Menu::find($actionVal['id']);
					endif;

					if(isset($actionVal['alias']) && $actionVal['alias'] != NULL && (isset($actionVal['header']) || isset($actionVal['footer']) || isset($actionVal['auth']) || isset($actionVal['id'])) ):

						$subMenu->controller = $packet.'/'.$controller;
						$subMenu->action = $action;
						$subMenu->actionAlias = $actionVal['alias'];
						$subMenu->header = (isset($actionVal['header']) && $actionVal['header']=='on')?1:0;
						$subMenu->footer = (isset($actionVal['footer']) && $actionVal['footer']=='on')?1:0;
						$subMenu->auth = (isset($actionVal['auth']) && $actionVal['auth']=='on')?1:0;
						$subMenu->admin = ($isAdmin)?$isAdmin:((isset($actionVal['admin']) && $actionVal['admin']=='on')?1:0);
						$subMenu->arrangement = isset($actionVal['arr'])?$actionVal['arr']:$actionArrangment;
						$subMenu->save();
					elseif(((!isset($actionVal['alias']) || $actionVal['alias'] == NULL) && $actionVal['id'] != 0) || isset($actionVal['remove']) ):
						$menu = Admin_Menu::find($actionVal['id'])->delete();
					endif;

					$actionArrangment++;
				}
			elseif(((!isset($field['alias']) || $field['alias'] == NULL) && $field['id'] != 0 ) || isset($field['remove']) ):
				$menu = Admin_Menu::find($field['id'])->delete();
			endif;

			$ctrlArrangment++;

			}
		}

		return Redirect::to('admin/console/menu');

	}

	public function get_acl(){

		$data['rolelist'] = Admin_UserRole::all();
		$data['page'] = Admin_Menu::pageExist();//all();

		$data['acl'] = Admin_UserAcl::aclRegistered();
		$data['acree'] = Acltree::render();


		return View::make('admin.console.acl',$data);
	}

	public function post_acl(){

		$input = Input::get();
		// echo "<pre>"; print_r($input);exit;

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

	public function get_setnav(){

		

		return View::make('admin.console.setnav',$data);

	}


}

?>