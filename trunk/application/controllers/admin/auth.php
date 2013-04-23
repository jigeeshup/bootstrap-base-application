<?php

class Admin_Auth_Controller extends Base_Controller {


    public function action_authenticate()
    {
        $input = Input::all();
        
        $rules = array(
            'username' => 'required|exists:users',
            'password' => 'required'
        );
        
        $validation = Validator::make($input, $rules);
        
        if( $validation->fails() ) {
            return Redirect::to('home')->with_errors($validation);
        }
        
        $credentials = array(
            'username' => $input['username'],
            'password' => $input['password']
        );

        if( Auth::attempt($credentials)) {
            return Redirect::to('eis/dashboard');
        } else {
            Session::flash('login_errors', 'Your email or password is invalid - please try again.');
            return Redirect::to(URL::base());
        }
        // }
    }

    public function action_verifyupdate(){

        $input = Input::all();

        $rules = array(
            'username' => 'required|exists:users',
            'password' => 'required'
        );
        
        // $validation = Validator::make($input, $rules);
        
        // if( $validation->fails() ) {
        //     return Redirect::to('home')->with_errors($validation);
        // }

        $existedUser = Admin_User::where('validationkey', '=', $input['key'])
        ->where('username', '=' ,$input['oldpassword'])
        ->where('status', '=', 'Pending')->first(array('userid'));


        $result = Admin_User::confirmUser($input,$existedUser->userid);


       if($result){

            $emel = Admin_UserProfile::find($existedUser->userid)->emel;
            
            try{

                $mailer = Message::to($emel);
                $mailer->from('admin@3fresorces.com', 'System Generate');
                $mailer->subject('User Registration Information');
                $mailer->body('view: plugins.emailAcc');
                $mailer->body->username = $input['username'];
                $mailer->body->password = $input['password'];
                $mailer->body->key = $input['key'] ;
                $mailer->html(true);
                $mailer->send();

            }catch (Exception $e) {
                Log::write('email', 'Message was not sent.');
                Log::write('email', 'Mailer error: ' . $e->getMessage());
            }

            $credentials = array(
                'username' => $input['username'],
                'password' => $input['password']
            );

            if( Auth::attempt($credentials)) {
                return Redirect::to('eis/dashboard');
            } else {
                Session::flash('login_errors', 'Your email or password is invalid - please try again.');
                return Redirect::to(URL::base());
            }

       }else{

            return Redirect::to('home/confirmation/'.$input['key']);

       }


    }
    
    public function action_logout()
    {
        Auth::logout();
        return Redirect::to(URL::base());
    }

}

?>