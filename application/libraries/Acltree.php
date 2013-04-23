<?php 

class Acltree{   

	protected static function datasource(){

		$page = Admin_Menu::pageExist();

		$dataMassage = array();

		foreach($page as $content){
			// $pieces = explode("/", $content->controller);
			// $dataMassage[$pieces[0]][$pieces[1]]['controller'] = $content->controller;
			if($content->action == ''){
				$dataMassage[$content->controller]['alias'] = $content->controlleralias ;
			}else{
				$dataMassage[$content->controller]['page'][$content->action] = $content->actionalias;
			}
			

		}

		return $dataMassage;
	}


	public static function render(){



		$rolelist = Admin_UserRole::all();
		$page = Acltree::datasource();//all();
		$acl = Admin_UserAcl::aclRegistered();

		// echo "<pre>";
		// print_r($page);
		// exit;
		$content = array();
		$fot = 1;
		foreach ($rolelist as $role){
			$subcontent = '';
			$subcontent .= '<ul class="nav nav-list">';
			foreach ($page as $controller => $selection){

				$subcontent .= '<li class="nav-header"><i class="icon-hdd"></i>&nbsp;'.Str::upper($selection['alias']).'</li>';
				$subcontent .=  '<div class="row-fluid">';				
				
				foreach ($selection['page'] as $action => $alias){
					
					$subcontent .= '<span style="padding-right:5px;width:auto;">';
					$subcontent .= Form::hidden($role->role.'[id]',$role->roleid);
					if(in_array($role->roleid,array_keys($acl)) && in_array($controller,array_keys($acl[$role->roleid])) &&  in_array($action,array_keys($acl[$role->roleid][$controller])) && $acl[$role->roleid][$controller][$action] == true){
						$subcontent .= Form::inline_labelled_checkbox($role->role.'['.$controller.']['.$action.']', Str::title($alias), null, array('checked'=>true,'style'=>'padding:2px'));
					}else{
						$subcontent .= Form::inline_labelled_checkbox($role->role.'['.$controller.']['.$action.']', $alias);
					}
					$subcontent .= '</span>';
					
				}
				$subcontent .=  '</div >'; 
				$subcontent .=  '<li class="divider"></li>';
			}
			$subcontent .= '</ul>';

			$active = ($fot == 1)? true:false;
			$fot ++;

			array_push($content,array(Str::upper($role->role),$subcontent,$active));
		}
		

		// echo "<pre>";
		// print_r($content);
		$nav = Navigation::links($content);
		$tab = Tabbable::tabs_left($nav);

		return $tab;

	}


}

?>
<!-- 
echo Tabbable::tabs_left(
  Navigation::links(
    array(
      array(
        'Section 1', 
        "<p>I'm in Section 1.</p>", 
        true
      ),
      array(
        'Section 2', 
        "<p>Howdy, I'm in Section 2.</p>"
      ),
      array(
        'Section 3', 
        "<p>What up girl, this is Section 3.</p>"
      ),
    )
  )
); -->