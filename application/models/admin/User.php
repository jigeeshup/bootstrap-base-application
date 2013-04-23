<?php
class Admin_User extends Eloquent
{
    public static $timestamps = false;
    public static $table = 'users';
    public static $key = 'userid';

    public static $rules = array( 
                                'username' => 'required|unique:users', 
                                'password' => 'required', 
                                'role' => ''
                            );

    
    public static function validate($data){
        return Validator::make($data, Static::$rules);
    }

    public function userprofile()
    {
        return $this->has_one('Admin_UserProfile','userid');
    }

    public function roles()
    {
        return $this->has_one('Admin_UserRole','roleid');
    }
    
    public static function listUser(){

        $allUser = Admin_User::all();

        $datagrid = new Datagrid;
        $datagrid->setFields(array('userprofile/fullname' =>'Fullname'));
        $datagrid->setFields(array('userprofile/emel' =>'Email'));
        $datagrid->setFields(array('userprofile/icno' =>'IC Number'));
        $datagrid->setFields(array('status' =>'Status'));
        $datagrid->setAction('view','deleteRole',true,array('userid'));
        $datagrid->setAction('reset','deleteRole',true,array('userid'));
        $datagrid->setTable('users','table table-bordered table-hover table-striped table-condensed');
        $datagrid->build($allUser,'userid');

        return $datagrid->render();

    }



    public static function registerUser($input){

        $User = new Admin_User;
        $id = $User->insert_get_id(array('username' => $input['username'],
                                        'password'=> Hash::make($input['password']) , 
                                        'validationkey'=>  $input['key'], 
                                        'status'=>  3, // 1 = active, 2=pendingc confirmation 3=unactive 
                                        'role'=>$input['role']));

        unset($input['username']);
        unset($input['password']);
        unset($input['role']);
        unset($input['key']);

        if($id){

        // $extension = File::extension($input['imgpath']['name']);
        // $directory = path('public').'avatar/'.sha1($id);
        // $filename = sha1($id.time()).".{$extension}";

        // if($input['imgpath']['size'] != null){

        //     $upload_success = Input::upload('photo', $directory, $filename);

        //     if( $upload_success ) {
        //         $input['imgpath'] = 'avatar/'.sha1($id).'/'.$filename;
        //     }else{
        //         $input['imgpath'] = '';
        //     }
        // }else{
        //     $input['imgpath'] = '';
        // }

            $profile = new Admin_UserProfile(array(
                'fullname' => $input['fullname'],
                'icno' => $input['icno'],
                // 'imgpath' => $input['imgpath'],
                // 'dob' => date('Y-m-d',strtotime($input['dob'])),
                // 'address' => $input['address'],
                'emel' => $input['emel']
                // 'postcode' => $input['postcode']
            ));

            $user = Admin_User::find($id);
            $user->userprofile()->insert($profile);  

            return $profile->exists; 

        }else{
            return false;
        }   

        
    }

    public static function confirmUser($input,$id = 0){

        if($id != 0){
            $user = Admin_User::find($id);
            $user->username  = $input['username'];
            $user->password  = Hash::make($input['password']) ;
            $user->status = 2;
            $user->save();

            return true;
        }else{
            return false;
        }


    }


}