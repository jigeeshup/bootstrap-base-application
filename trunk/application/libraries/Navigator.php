<?php 


/*********************************************************************
*  Class : Navigator
*  Function : 
*  Author :  joharijumali
*  Description: Class for Creating System Navigation
**********************************************************************/

class Navigator{

    /**
     * sidebar function
     * Create sidebar
     * @return string
     * @author joharijumali
     **/

  public static function sidebar() {

      $Menu = Admin_Menu::menuGenerator();
      $Menu = Admin_Nav::navigationdata();

      $navValue = array();

      foreach($Menu as $floor => $packet){

        array_push($navValue, array(Navigation::HEADER, Str::upper($packet['header']) ));
        if(!empty($packet['parent'])){
          foreach ($packet['parent'] as $key => $action){
          
              array_push($navValue, array(Str::title($action['alias']) , url($action['path']), ($action['path'] == URI::segment(2).'/'.URI::segment(3))?true:false, false, null, 'edit'));
          
          }        
        }
  
        array_push($navValue, array(Navigation::DIVIDER));
      }
    
    $final = Navigation::lists(Navigation::links($navValue));

    return $final;

  }

    /**
     * breadcrumb function
     * Create breadcrumb
     * @return string
     * @author joharijumali
     **/

  public static function breadcrumb(){

    $Menu = Admin_Menu::menuGenerator();

    $butternbread = array();

    foreach ($Menu as $floor => $packet){
      foreach ($packet->page->action as $key => $action){
         if($packet->packet == Str::lower(URI::segment(1)) && $packet->controller->name == Str::lower(URI::segment(2)) && $action->name == Str::lower(URI::segment(3)) || (URI::segment(3) == NULL && $action->name == $packet->controller->name && Str::lower(URI::segment(2)) == $packet->controller->name)){
            $butternbread[Str::upper($packet->controller->alias)] = '#' ;
            array_push($butternbread, Str::title($action->alias));
        }
      }
    }

    return Breadcrumb::create($butternbread);

  }

}



?>