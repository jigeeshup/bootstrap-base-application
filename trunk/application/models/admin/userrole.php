<?php

class Admin_UserRole extends Eloquent
{
	public static $timestamps = false;
	public static $table = 'users_roles';
	public static $key = 'roleid';
	
	public function user()
	{
		return $this->belongs_to('Admin_User');
	}

	public static function listRole(){

		Bundle::start('datagrid');

		$rolelist = Admin_UserRole::where('roleid', '<>', 1)->get();

		$datagrid = new Datagrid;
		$datagrid->setFields(array('roleid'=>'Role Id','role'=>'User Role Description'));
		$datagrid->setAction('edit','editRoleModal',true,array('roleid'));//false,array('id'=>'roleid','data-toggle'=>'modal'));
		$datagrid->setAction('delete','deleteRole',true,array('roleid'));
		$datagrid->setContainer('list01','span12');
		$datagrid->setTable('users','table table-bordered table-hover table-striped table-condensed');
		$datagrid->build($rolelist,'roleid');

		return $datagrid->render();

	}

	public function acl()
	{

		return $this->has_many('Admin_UserAcl', 'roleid');
	}

	public static function arrayRoles()
	{
		$rolelist = Admin_UserRole::all();

		$arrayRole = array();

		foreach ($rolelist as $value) {
			if(Auth::check() && Auth::user()->role != 1 &&  $value->roleid != 1){
				$arrayRole[$value->roleid] = $value->role;
			}else{
				$arrayRole[$value->roleid] = $value->role;
			}
		}

		return $arrayRole;
	}

}
