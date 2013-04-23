<?php

class Admin_User_Controller extends Base_Controller {

public $restful = true;

    public function get_index(){
        return Redirect::to('admin/user/userlist');
    }

    public function get_userList()
    {
        $data['userlist'] = $allUser = Admin_User::listUser();
        $data['allrole'] = Admin_UserRole::arrayRoles();

        return View::make('admin.user.userlist',$data);
    }


    public function post_register()
    {   
        $input = Input::all();

        $input['key'] = $key = Str::random(32, 'alpha');

        // $validation = User::validate($input);
        // $validateProfile = UserProfile::validate($input);

        // if( $validation->fails()) {
        //     return Redirect::to('auth/register')->with_errors($validation)->with_input();
        // }elseif($validateProfile->fails()){
        //     return Redirect::to('auth/register')->with_errors($validateProfile)->with_input();
        // }

       $resgisteredUser = Admin_User::registerUser($input);

       if($resgisteredUser){

            try{

                $mailer = Message::to($input['emel']);
                $mailer->from('admin@3fresorces.com', 'System Generate');
                $mailer->subject('User Registration Confirmation');
                $mailer->body('view: plugins.email');
                $mailer->body->username = $input['username'];
                $mailer->body->password = $input['password'];
                $mailer->body->key = $key ;
                $mailer->html(true);
                $mailer->send();

            }catch (Exception $e) {
                Log::write('email', 'Message was not sent.');
                Log::write('email', 'Mailer error: ' . $e->getMessage());
            }

           return Admin_User::listUser();
       }

    }

    public function post_resetlogin(){

        $validatekey = Str::random(32, 'alpha');

        $uname = Str::random(16, 'alpha');

        $user = Admin_User::find(Auth::user()->userid);
        $user->username = $uname;
        $user->password = $uname;
        $user->status = 3;
        $user->validationkey = $validatekey;
        $user->save();

        try{

            $mailer = Message::to($user->userprofile->emel);
            $mailer->from('admin@3fresorces.com', 'System Generate');
            $mailer->subject('Account Login Reset');
            $mailer->body('view: plugins.email');
            $mailer->body->username = $uname;
            $mailer->body->password = $uname;
            $mailer->body->key = $key ;
            $mailer->html(true);
            $mailer->send();

        }catch (Exception $e) {
            Log::write('email', 'Message was not sent.');
            Log::write('email', 'Mailer error: ' . $e->getMessage());
        }

    }


    public function post_resetpassword(){

        $input = Input::all();

        $user = Admin_User::find(Auth::user()->userid);

        if( Hash::check($input['oldpassword'],$user->password) && $input['password'] == $input['repassword']){

            $user->password = Hash::make($input['password']);
            $user->save();

        }

    }

    public function get_profile()
    {

        $profile = Admin_UserProfile::loggedprofile();

        return $profile;

    }


    public function post_profile()
    {

        $input = Input::all();

        // $validation = Admin_UserProfile::validate($input);

        // if( $validation->fails() ) {
        //     return Redirect::to('user/profile')->with_errors($validation)->with_input();
        // }

        // $extension = File::extension($input['photo']['name']);
        // $directory = path('public').'avatar/'.sha1(Auth::user()->userid);
        // $filename = sha1(Auth::user()->userid.time()).".{$extension}";


        $profile = Admin_UserProfile::find(Auth::user()->userid);

        // if($input['photo']['size'] != null){
        //     $upload_success = Input::upload('photo', $directory, $filename);

        //     if( $upload_success ) {

        //         while(is_file('public/'.$profile->imgpath) == TRUE)
        //         {
        //             chmod('public/'.$profile->imgpath, 0666);
        //             unlink('public/'.$profile->imgpath);
        //         }

        //         $profile->imgpath = 'avatar/'.sha1(Auth::user()->userid).'/'.$filename;
        //     }
        // }

        $profile->fullname  = $input['fullname'];
        $profile->dob  = date('Y-m-d',strtotime($input['dob']));
        $profile->address = $input['address'];
        $profile->postcode = $input['postcode'];
        $profile->emel = $input['emel'];
        $profile->town = $input['town'];
        $profile->city = $input['city'];
        $profile->icno = $input['icno'];

        $profile->save();

        $profile = Admin_UserProfile::loggedprofile();

        return $profile;

    }

	public function get_role(){

		$data['rolelist'] = $rolelist = Admin_UserRole::listRole();

		return View::make('admin.user.role',$data);
	}

    public function get_roleinfo(){
        $input = Input::get();

        $role = Admin_UserRole::find($input['roleid']);
        
        $data['role'] = $role->role;
        $data['roledesc'] = $role->roledesc;
        $data['roleid'] = $role->roleid;

        return json_encode($data);
    }

	public function post_role(){

		$input = Input::get();
        // print_r($input);exit;

		if($input['roleid'] == NULL):
			$role = new Admin_UserRole;
		else:
			$role = Admin_UserRole::find($input['roleid']);
		endif;
        $role->role  = $input['role'];
        $role->save();

        return Admin_UserRole::listRole();

	}

    public function post_deleterole(){
        $input = Input::get();

        Admin_UserRole::find($input['id'])->acl()->delete();
        Admin_UserRole::find($input['id'])->delete();

        return Admin_UserRole::listRole();
    }


}

?>