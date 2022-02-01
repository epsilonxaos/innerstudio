<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Session;
use URL;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $url_previa = URL::previous();
        $url = explode("/", $url_previa);
        $url_end = end($url);

        $this->validate($request, [
            'username' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $customer = self::getCustomer($request -> username);
     
        if($customer!=null){

            if($customer ->type == 1 && $url_end == "login" ){
                return redirect() -> route('index');
            }

            if($customer ->type == 0  && $url_end != "login"){
                return redirect() -> route('login.admin');
            }
        }else{
            return redirect()
                -> back()
                -> with('message_login', 'No existe el usuario');
        }

        if(isset($request -> remember)){ $remember = true; }
        else{ $remember = false; }

        if (Auth::attempt(['email' => $request -> username, 'password' => $request->password]))
        {
            // Este para perfil
            if ($customer -> type == 1){
                    return redirect() -> route('profile');
                
            }else{
                    return redirect() -> route('admin.customer.list');
               
            }
        }
        else
        {
            return redirect()
                -> back()
                -> with('message_login', 'El usuario y/o contraseña son incorrectos');
        }
    }

    public function login_panel () {
        return view('admin.login');
    }

    static public function getCustomer($email){
        $result = User::where('email', $email)
            -> first();

        return $result;
    }
}
