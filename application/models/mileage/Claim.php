<?php
class Mileage_Claim extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'Mileage_Request';
    public static $key = 'requestid';

    public static function aclRegistered(){

		$aclList = Admin_UserAcl::all();

		$data = array();

		foreach($aclList as $val){
			$data[$val->roleid][$val->controller][$val->action] = true;
		}

		return $data;

    } 
    
}

?>	

<!-- 
	public static function listApp(){

		$listApp = Application::all();

		$datagrid = new Datagrid;
		$datagrid->setFields(array('appname'=>'Application','appdesc'=>'Description','created_at'=> 'Create On'));
		$datagrid->setAction('flow','setup');
		// $datagrid->setAction('delete','deleteRole',true,array('roleid'));
		$datagrid->setTable('app','app2');
		$datagrid->build($listApp, 'appid');

		return $datagrid->render();

	} -->