<?php 

class Navigator{

  public static function sidebar() {

      $Menu = Admin_Menu::menuGenerator();

      $navValue = array();

      foreach($Menu as $floor => $packet){
        array_push($navValue, array(Navigation::HEADER, Str::upper($packet->controller->alias) ));

        foreach ($packet->page->action as $key => $action){
          if($action->header){
            array_push($navValue, array(Str::title($action->alias) , url($packet->packet.'/'.$packet->controller->name.'/'.$action->name), ($action->status != NULL)?true:false, false, null, 'edit'));
          }
        }
        array_push($navValue, array(Navigation::DIVIDER));
      }
    
    $final = Navigation::lists(Navigation::links($navValue));

    return $final;

  }

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
    // return $butternbread;

  }

}



?>