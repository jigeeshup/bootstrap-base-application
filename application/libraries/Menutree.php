<?php 

class Menutree{   

	public static function dataTree(){

		$Menus = Admin_Menu::all();

		$selected = array();
		
		foreach ($Menus as $menu)
		{
			$pieces = explode("/", $menu->controller);

			if($menu->action == NULL){
				$selected[$pieces[0]][$pieces[1]] = array(
					'id' => $menu->menuid,
					'alias' => $menu->controlleralias,
					'footer' => ($menu->footer == 1)?'checked':'',
					'header' => ($menu->header == 1)?'checked':'',
					'arrangement' => $menu->arrangement ,
					'auth' => ($menu->auth == 1)?'checked':'',
					'admin' => ($menu->admin == 1)?'checked':''
					);
			}else{

				$selected[$pieces[0]][$pieces[1]][$menu->action] = array(
					'id' => $menu->menuid,
					'alias' => $menu->actionalias,
					'footer' => ($menu->footer == 1)?'checked':'',
					'header' => ($menu->header == 1)?'checked':'',
					'arrangement' => $menu->arrangement ,
					'auth' => ($menu->auth == 1)?'checked':'',
					'admin' => ($menu->admin == 1)?'checked':''
					);

				// $cotdeaveira = array();
				// foreach($navigation[$pieces[0]][$pieces[1]] as $key => $page){
				// 	array_push($cotdeaveira, $page['page']);
				// }

				// if(!in_array($menu->action, $cotdeaveira)){
				// 	$selected[$pieces[0]][$pieces[1]][$menu->action]['deleted']= true;
				// }

			}

		}

		return $selected;

   }

   public static function fileTree(){

		$navigation = array();
		$packet = glob('application/controllers/*',GLOB_NOESCAPE);

		foreach ($packet as $part) {
			$folder = basename($part,'.php');

			$controllers = glob('application/controllers/'.$folder.'/*.php',GLOB_NOESCAPE);

			if(!empty($controllers)){
				foreach ($controllers as $controllerName) {

					$ctrl = basename($controllerName,'.php');

					$views = glob('application/views/'.$folder.'/'.$ctrl.'/*.blade.php',GLOB_NOESCAPE);

					if(!in_array($ctrl, array('auth','base'))){
						if(!empty($views)){
							foreach ($views as $id => $viewsName) {
								$action = basename($viewsName,'.blade.php');
								// if($action != 'index'):
									$navigation[$folder][$ctrl][$id]['page'] = $action;
									$navigation[$folder][$ctrl][$id]['path'] = $viewsName;
								// endif;
							}
						}else{
							$navigation[$folder][$ctrl] = NULL;
						}
					}
				}

			}
		}

		return $navigation;
   }

   	public static function render(){

		$registered = Menutree::dataTree();
		$navigation = Menutree::fileTree();
		$sourcePage = array();

		$view = '<ul class="nav nav-list">';

	    foreach ($navigation as $folder => $controller){
	    	$view .= '<li class="nav-header"><i class="icon-hdd"></i>&nbsp;'.Str::upper($folder).'</li>';
	    	
			foreach ($controller as $ctrl => $action){

				$view .=  '<ul ><li class="">';
				$view .=  Form::hidden($folder.'['.$ctrl.'][id]',isset($registered[$folder][$ctrl])?$registered[$folder][$ctrl]['id']:0);
				$view .=  Form::text($folder.'['.$ctrl.'][arr]', (isset($registered[$folder][$ctrl])?$registered[$folder][$ctrl]['arrangement']:'#'), array('class' => 'input-mini', 'placeholder' => '#',
						'style'=>'width:20px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);background:none repeat scroll 0 0 rgba(0, 0, 0, 0.2);color:#fff'));
				$view .=  '<i class="icon-folder-close"></i>&nbsp;'.Str::title($ctrl);



				$id = (isset($registered[$folder][$ctrl])) ? $registered[$folder][$ctrl]['id'] : '';
				$alias = (isset($registered[$folder][$ctrl]))?$registered[$folder][$ctrl]['alias']:'';
				$header = (isset($registered[$folder][$ctrl]))?$registered[$folder][$ctrl]['header']:'';
				$footer = (isset($registered[$folder][$ctrl]))?$registered[$folder][$ctrl]['footer']:'';
				$auth = (isset($registered[$folder][$ctrl]))?$registered[$folder][$ctrl]['auth']:'';
				$admin = (isset($registered[$folder][$ctrl]))?$registered[$folder][$ctrl]['admin']:'';
				$arrangement = (isset($registered[$folder][$ctrl]))?$registered[$folder][$ctrl]['arrangement']:'#';


	    		$view .=  '<span class="">';
	            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.'][alias]">';
	            $view .=  'Screen Name :<input type="text" class="input-mini" name="'.$folder.'['.$ctrl.'][alias]" value="'.$alias.'">';
	            $view .=  '</label>';
	            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.'][header]">';
	            $view .=  'Show : <input type="checkbox" class="input-mini" name="'.$folder.'['.$ctrl.'][header]"';
	            $view .=  $header.' id="'.$folder.'['.$ctrl.'][header]" > ';
	            $view .=  '</label>';
	            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.'][footer]">';
	            $view .=  'Hide : <input type="checkbox" class="input-mini" name="'.$folder.'['.$ctrl.'][footer]"';
	            $view .=  $footer.' id="'.$folder.'['.$ctrl.'][footer]" > ';
	            $view .=  '</label>';
	            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.'][auth]">';
	            $view .=  'Auth:<input type="checkbox" class="input-mini" name="'.$folder.'['.$ctrl.'][auth]"';
	            $view .=  $auth.' id="'.$folder.'['.$ctrl.'][auth]" > ';
	            $view .=  '</label>';
	            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.'][admin]">';
	            $view .=  ' Admin Only:<input type="checkbox" name="'.$folder.'['.$ctrl.'][admin]"';
	            $view .=  $admin.' id="'.$folder.'['.$ctrl.'][admin]" > ';
	            $view .=  '</label>';
	            $view .=  '</span>';

	            
			  	if(isset($registered[$folder][$ctrl])){
			  		
				    unset($registered[$folder][$ctrl]['id']);
				    unset($registered[$folder][$ctrl]['alias']);
				    unset($registered[$folder][$ctrl]['footer']);
				    unset($registered[$folder][$ctrl]['header']);
				    unset($registered[$folder][$ctrl]['arrangement']);
				    unset($registered[$folder][$ctrl]['auth']);
				    unset($registered[$folder][$ctrl]['admin']);

					$sourcePage = $registered[$folder][$ctrl];
					unset($registered[$folder][$ctrl]);

			  	}

				$view .=  '<ul>';

			  	if(!empty($action)){

			  		foreach ($action as $key => $page) {

						// $style = (isset($sourcePage[$page['page']]))? 'alert-success':'alert-info';

				  		$view .=  '<li>';

						$id = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['id']:'';
						$alias = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['alias']:'';
						$header = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['header']:'';
						$footer = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['footer']:'';
						$auth = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['auth']:'';
						$admin = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['admin']:'';
						$arrangement = (isset($sourcePage[$page['page']]))?$sourcePage[$page['page']]['arrangement']:'#';


		  				$view .=  Form::hidden($folder.'['.$ctrl.']['.$page['page'].'][id]',$id);
		  				$view .=  Form::text($folder.'['.$ctrl.']['.$page['page'].'][arr]', $arrangement, array('class' => 'input-mini', 'placeholder' => '#',
		  							'style'=>'width:20px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);background:none repeat scroll 0 0 rgba(0, 0, 0, 0.2);color:#fff'));
						$view .=  '<i class="icon-list-alt"></i>&nbsp;'.Str::title($page['page']).'&nbsp;<em>'.Str::title($page['path']).'</em>';


		  				$view .=  '<span class="">';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.']['.$page['page'].'][alias]">';
			            $view .=  'Screen Name :<input type="text" class="input-mini" name="'.$folder.'['.$ctrl.']['.$page['page'].'][alias]"';
			            $view .=  'value="'.$alias.'">';
			            $view .=  '</label>';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.']['.$page['page'].'][header]">';
			            $view .=  'Show : <input type="checkbox" class="input-mini" name="'.$folder.'['.$ctrl.']['.$page['page'].'][header]"';
			            $view .=  $header.' id="'.$folder.'['.$ctrl.']['.$page['page'].'][header]" > ';
			            $view .=  '</label>';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.']['.$page['page'].'][footer]">';
			            $view .=  'Hide : <input type="checkbox" class="input-mini" name="'.$folder.'['.$ctrl.']['.$page['page'].'][footer]"';
			            $view .=  $footer.' id="'.$folder.'['.$ctrl.']['.$page['page'].'][footer]" > ';
			            $view .=  '</label>';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.']['.$page['page'].'][auth]">';
			            $view .=  'Auth:<input type="checkbox" class="input-mini" name="'.$folder.'['.$ctrl.']['.$page['page'].'][auth]"';
			            $view .=  $auth.' id="'.$folder.'['.$ctrl.']['.$page['page'].'][auth]" > ';
			            $view .=  '</label>';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.']['.$page['page'].'][admin]">';
			            $view .=  ' Admin Only:<input type="checkbox" name="'.$folder.'['.$ctrl.']['.$page['page'].'][admin]"';
			            $view .=  $admin.' id="'.$folder.'['.$ctrl.']['.$page['page'].'][admin]" > ';
			            $view .=  '</label>';
			            $view .=  '</span>';

				  		$view .= '</li>';
			  			unset($sourcePage[$page['page']]);
			  		}
			    }

			    if(!empty($sourcePage)){
			  		$view .=  '<li class="divider"></li>';
			  		foreach ($sourcePage as $action => $page) {

			  			$view .=  '<li>';
		  				$view .=  '<i class="icon-remove"></i>&nbsp;'.Str::title($page['alias']).'&nbsp;<em>'.$folder.'/'.$ctrl.'/'.$action.'</em>';
		  				$view .=  Form::hidden($folder.'['.$ctrl.']['.$action.'][id]',$page['id']);
		  				$view .=  '<span style="padding-right:10px">';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$ctrl.']['.$action.'][remove]">';
			            $view .=  ' Remove:<input type="checkbox" name="'.$folder.'['.$ctrl.']['.$action.'][remove]"';
			            $view .=  ' id="'.$folder.'['.$ctrl.']['.$action.'][remove]" > ';
			            $view .=  '</label>';
			            $view .=  '</span>';
		  				$view .= '</li>';
			  		}

			    }
			    $view .=  '</ul >';

			  	$view .= '</li></ul>';
	    	}	

	    	if(empty($registered[$folder])){
	    		unset($registered[$folder]);
	    	}
	    }
	    
	    if(!empty($registered)){

	    	$view .=  '<li class="divider"></li>';
	    	foreach ($registered as $folder => $content) {
	    		if(!empty($content)){
	    			$view .=  '<li class="alert alert-error" style="padding-right:10px">';
	    			foreach ($content as $controller => $action) {
			  			
		  				$view .=  '<i class="icon-remove"></i>&nbsp;'.Str::title($action['alias']).'&nbsp;<em>'.$folder.'/'.$controller.'</em>';
		  				$view .=  Form::hidden($folder.'['.$controller.'][id]',$action['id']);
		  				$view .=  '<span style="padding-right:10px">';
			            $view .=  '<label class="checkbox" for="'.$folder.'['.$controller.'][remove]">';
			            $view .=  ' Remove:<input type="checkbox" name="'.$folder.'['.$controller.'][remove]"';
			            $view .=  ' id="'.$folder.'['.$controller.'][remove]" > ';
			            $view .=  '</label>';
			            $view .=  '</span>';
		  				
	    			
		    			unset($action['id']);
					    unset($action['alias']);
					    unset($action['footer']);
					    unset($action['header']);
					    unset($action['arrangement']);
					    unset($action['auth']);
					    unset($action['admin']);

					    foreach($action as $func => $page){
					    	$view .=  '<ul>';
					    	$view .=  '<li>';
			  				$view .=  '<i class="icon-remove"></i>&nbsp;'.Str::title($page['alias']).'&nbsp;<em>'.$folder.'/'.$controller.'/'.$func.'</em>';
			  				$view .=  Form::hidden($folder.'['.$controller.']['.$func.'][id]',$page['id']);
			  				$view .=  '<span style="padding-right:10px">';
				            $view .=  '<label class="checkbox" for="'.$folder.'['.$controller.']['.$func.'][remove]">';
				            $view .=  ' Remove:<input type="checkbox" name="'.$folder.'['.$controller.']['.$func.'][remove]"';
				            $view .=  ' id="'.$folder.'['.$controller.']['.$func.'][remove]" > ';
				            $view .=  '</label>';
				            $view .=  '</span>';
			  				$view .= '</li>';
					    	$view .=  '</ul >';
					    }
	    			}
					$view .= '</li>';
	    		}
	    	}
	    }

	    $view .= '</ul>';

	    return $view;
   	}

}