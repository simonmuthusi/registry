<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Mail;
use Config;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            // 'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $mypassword = str_random(8);

        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($mypassword),
            // 'password' => bcrypt($data['password']),
        ]);

        // send user email with login credentials
        $subject_body = "New user created on ".Config::get('app.name');
        $message_body = "Hi ".$data['name']."\nYou have been created as a user on ".Config::get('app.name')."\nLogin credentials:\nUsername: ".$data['email']."\nPassword: ".$mypassword."\nThanks ".Config::get('app.name'). " Team";

        $mail_data = array(
            "subject"=>$subject_body,
            "body"=>$message_body,
            "participants"=>$data['email'],
            );
        try{
            Mail::send([], [], function ($message) use ($mail_data) {
              $message->to($mail_data['participants'])
                ->subject($mail_data['subject'])
                ->setBody($mail_data['body']);
            });
        }
        catch(Exception $e)
        {
            Session::flash('error_message', 'User created but email not sent. Username: '.$data['email']." Password: ".$mypassword);
        }

        return $user;

    }
}
