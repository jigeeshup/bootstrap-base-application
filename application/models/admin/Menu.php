<?php
class Admin_Menu extends Eloquent
{
    public static $timestamps = true;
    public static $table = 'menus';
    public static $key = 'menuid';

    public static function pageExist()
    {
    	$menu = Admin_Menu::where('auth', '<>', 0)->order_by('arrangement', 'asc')->get();
        return $menu;
    }

    public static function pageAccesible(){

    	$menu = Admin_Menu::where('action', '<>', '')->get();

    	$data = array();

    	foreach($menu as $pages){
    		$data[$pages->menuid] = $pages->actionalias;
    	}

    	return $data;
    }

    public static function menuGenerator(){

        $Menus = Admin_Menu::order_by('arrangement', 'asc')->get();;
        $acces = Admin_UserAcl::aclRegistered();

    	$selected = new stdClass();
        $page = new stdClass();
        $dev = array();
        $sub = array();

        $logged_user = Auth::user();

        foreach ($Menus as $id => $menu)
        {
            $content = new stdClass();
            $controller = new stdClass();
            $action = new stdClass();


            $pieces = explode("/", $menu->controller);

            if($menu->action == NULL || ($menu->header == 1 && $menu->footer == 1)){

                $content->footer = $menu->footer;
                $content->header = $menu->header;
                $content->auth = $menu->auth;
                $content->admin = $menu->admin;
                $content->packet = $pieces[0];

                if($menu->action == NULL && ($menu->header == 1 || $menu->footer == 1)):

                    $controller->name = $pieces[1];
                    $controller->alias = $menu->controlleralias;

                else:

                    $controller->name = $menu->action;
                    $controller->alias = $menu->actionalias;

                endif;
                
                $content->controller = $controller;

                if($content->controller->name == URI::segment(2)):
                    $content->status = "active";
                else:
                    $content->status = "";
                endif;



            }elseif($menu->action != NULL && ($menu->header != 0 || $menu->footer != 0)){

                $action->name = $menu->action;
                $action->alias = $menu->actionalias;
                $action->footer = $menu->footer;
                $action->header = $menu->header;
                $action->auth = $menu->auth;

                if($action->name == URI::segment(3) || (URI::segment(3) == NULL && $action->name == $pieces[1] && URI::segment(2) == $pieces[1])):
                    $action->status = "active";
                else:
                    $action->status = "";
                endif;

                //check acl access
                if(Auth::check()){

                    if(isset($acces[$logged_user->role])){
                        if(isset($acces[$logged_user->role][$menu->controller])){
                            if(isset($acces[$logged_user->role][$menu->controller][$menu->action])){
                                $sub[$pieces[1]][]=$action;
                            }
                        }
                    }
                }else{
                    $sub[$pieces[1]][]=$action;
                }

            }

            $cont = (array)$content;
            if(!empty($cont)){

                $dev[$id] = $content;     
            }


        }

        $final = array();

        foreach ($dev as $key => $value) {
            
            $action = new stdClass();
            $page = new stdClass();
            $ctrl = $value->controller->name;

            if(!empty($sub[$ctrl])){

                $action->action = $sub[$ctrl];
            }          

            $value->page = $action;

            // check acl access
            if(Auth::check()){
                $pages = (array)$value->page;       

                if(isset($acces[$logged_user->role]) ){
                    if(isset($acces[$logged_user->role][$value->packet.'/'.$ctrl])){
                        if((!empty($pages) || $ctrl == 'dashboard') && (($value->admin == 1) ? $value->admin == Auth::user()->role : TRUE)){
                            $final[$key] = $value;
                        }
                    }
                }
            }else{
                $final[$key] = $value;
            }

        }

    	return $final;
    }

    
}