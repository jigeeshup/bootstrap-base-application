<?php
class Admin_UserAcl extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'users_acl';
    public static $key = 'aclid';

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