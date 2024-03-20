<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }

        public function login(Request $request)
        {
            $error_messages = [
                "email.required" => "Remplir le champ email!",
                "email.email" => "La structure d'un email n'est pas respecte!",
                "password.required" => "Remplir le champ mot de passe!",
            ];

            $validator = Validator::make($request->all(),[
                'email' => ['required', 'email'],
                'password' => ['required']
            ], $error_messages);

            if($validator->fails())
                return response()->json([
                "status" => false,
                "reload" => false,
                "title" => "CONNEXION ECHOUEE",
                "msg" => $validator->errors()->first()]);
            
            $user = User::where('email', $request-> email)->first();
            $School = School::where('id', $user->school_id )->first();

            if($user && Hash::check($request-> password, $user-> password)){
                if($user->user_type == 1){
                    Auth::login($user);
                    // $request->session()->regenerate();           
                    return response()->json([
                        "status" => true,
                        "reload" => true,
                        "redirect_to" => route('tableau'),
                        "title" => "CONNEXION REUSSIE",
                        'check' => Auth::check(),
                        "msg" => "connexion réussie."
                    ]);
                }elseif($user->user_type == 2){
                    if($School){
                        if($School->connected==1){
                            Auth::login($user);         
                            return response()->json([
                                "status" => true,
                                "reload" => true,
                                "redirect_to" => route('dashboardAdmin'),
                                "title" => "CONNEXION REUSSI",
                                'check' => Auth::check(),
                                "msg" => "connexion réussie"
                            ]);
                        }else{
                            return response()->json([
                                "status" => false,
                                "reload" => true,
                                'check' => Auth::check(),
                                "title" => "CONNECTION ECHOUEE",
                                "msg" => "Vous n'êtes pas autoriser à vous connecter"
                            ]);
                        }
                    }else{
                        Auth::login($user);         
                        return response()->json([
                            "status" => true,
                            "reload" => true,
                            "redirect_to" => route('dashboardAdmin'),
                            "title" => "CONNEXION REUSSI",
                            'check' => Auth::check(),
                            "msg" => "connexion réussie"
                        ]);
                    }
                }else{
                    if($School AND $School->connected==1){
                        if($user->connected){
                            Auth::login($user);
                            return response()->json([
                                "status" => true,
                                "reload" => true,
                                "redirect_to" => route('tableau'),
                                "title" => "CONNEXION REUSSIE",
                                'check' => Auth::check(),
                                "msg" => "connexion réussie"
                            ]);
                        }else{
                            return response()->json([
                                "status" => false,
                                "reload" => true,
                                'check' => Auth::check(),
                                "title" => "CONNECTION ECHOUEE",
                                "msg" => "Vous n'êtes pas autoriser a vous connecter"
                            ]);
                        }
                    }else{
                        return response()->json([
                            "status" => false,
                            "reload" => true,
                            'check' => Auth::check(),
                            "title" => "CONNECTION ECHOUEE",
                            "msg" => "Vous n'êtes pas autoriser à vous connecter"
                        ]);
                    }
                }
            }else{
                return response()->json([
                    "status" => false,
                    "reload" => true,
                    'check' => Auth::check(),
                    "title" => "CONNECTION ECHOUEE",
                    "msg" => "Les informations du mail ou mot de passe sont incorrectes"
                ]);
            }
        }
}