<?php
class Admin_Modul extends Eloquent
{
    public static $timestamps = true;
    public static $table = 'moduls';
    public static $key = 'modulid';


    public static function getRegPages(){
        
        $strucModel = Admin_Modul::where('modul', '<>', 'admin')->order_by('modulid', 'asc')->get();//where('modul', '<>', 'admin')->

        $structModeling = array();

        foreach ($strucModel as $value) {

            if($value->action == NULL){

                $structModeling[$value->modul]['modulalias'] = $value->modulalias ;

                $structModeling[$value->modul][$value->controller] = array( 
                    'modulid' => $value->modulid ,
                    'controlleralias' => $value->controlleralias,
                    'visible' => $value->visible,
                    'header' => $value->header,
                    'footer' => $value->footer,
                    'auth' => $value->auth,
                    'admin' => $value->admin,
                    'arrangement' => $value->arrangement,

                );

            }else{

                $structModeling[$value->modul]['modulalias'] = $value->modulalias ;

                $structModeling[$value->modul][$value->controller][$value->action] = array( 
                    'modulid' => $value->modulid ,
                    'actionalias' => $value->actionalias,
                    'visible' => $value->visible,
                    'header' => $value->header,
                    'footer' => $value->footer,
                    'auth' => $value->auth,
                    'admin' => $value->admin,
                    'arrangement' => $value->arrangement,

                );
            }
        }

        return $structModeling;
    }

    public static function getdatapages(){

        $regVal = Admin_Modul::getRegPages();
        $registered = array();

        foreach ($regVal as $modul => $contents) {
           unset($contents['modulalias']);

           $registered[$modul] = array();

           foreach ($contents as $submodul => $subcontent) {
               
               unset($subcontent['modulid']);
               unset($subcontent['controlleralias']);
               unset($subcontent['visible']);
               unset($subcontent['header']);
               unset($subcontent['footer']);
               unset($subcontent['auth']);
               unset($subcontent['admin']);
               unset($subcontent['arrangement']);

               $registered[$modul][$submodul]= array();

               foreach ($subcontent as $action => $actioncontent) {
                    
                    $registered[$modul][$submodul][$action] = array();

               }

           }
        }

        return $registered;

    }

    public static function setPages($component){

    			
    	$ctrlArrangment = count($component) + 1;

		foreach($component as $modul => $modulcontents){
        	unset($modulcontents['id']);
        	$ctrlArrangment = count($modulcontents) + 1;
        	foreach ($modulcontents as $submodul => $submodulcontents) {
				
				if($submodulcontents['id'] == 0):
					$menu = new Admin_Modul();
				else:
					$menu = Admin_Modul::find($submodulcontents['id']);
				endif;

                if(isset($submodulcontents['remove']) && $submodulcontents['remove'] == 1){

                    Admin_Modul::find($submodulcontents['id'])->delete();
                    unset($submodulcontents['remove']);

                }else{

                    $menu->modul = $modul;
                    $menu->controller = $submodul;
                    $menu->controlleralias = $submodulcontents['controlleralias'];
                    $menu->visible = (isset($submodulcontents['show']) && $submodulcontents['show']=='on')?1:0;
                    $menu->auth = (isset($submodulcontents['auth']) && $submodulcontents['auth']=='on')?1:0;
                    $menu->admin = (isset($submodulcontents['admin'])&& $submodulcontents['admin']=='on')?1:0;
                    $menu->arrangement = isset($submodulcontents['arrangement'])?$submodulcontents['arrangement']:$ctrlArrangment;
                    $menu->save();


                    unset($submodulcontents['arrangement']);
                    unset($submodulcontents['controlleralias']);
                    unset($submodulcontents['show']);
                    unset($submodulcontents['auth']);
                    unset($submodulcontents['admin']);
                }

        		unset($submodulcontents['id']);

                $actionArrangment = count($submodulcontents) + 1;

        		foreach ($submodulcontents as $action => $actioncontents) {


                    if($actioncontents['id'] == 0):
                        $menu = new Admin_Modul();
                    else:
                        $menu = Admin_Modul::find($actioncontents['id']);
                    endif;

                    if(isset($actioncontents['remove']) && $actioncontents['remove'] == 1){

                        Admin_Modul::find($actioncontents['id'])->delete();

                    }else{
                        
                        $menu->modul = $modul;
                        $menu->controller = $submodul;
                        $menu->action = $action;
                        $menu->actionalias = $actioncontents['actionalias'];
                        $menu->visible = (isset($actioncontents['show']) && $actioncontents['show']=='on')?1:0;
                        $menu->auth = (isset($actioncontents['auth']) && $actioncontents['auth']=='on')?1:0;
                        $menu->admin = (isset($actioncontents['admin']) && $actioncontents['admin']=='on')?1:0;
                        $menu->arrangement = isset($actioncontents['arrangement'])?$actioncontents['arrangement']:$actionArrangment;
                        $menu->save();
                    }

                    unset($submodulcontents[$action]);

                    $actionArrangment++;
        		}

        		$ctrlArrangment++;
        	}

		}


    } 

}