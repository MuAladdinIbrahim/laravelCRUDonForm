<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;


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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubCallback()
    {
        $github_user = Socialite::driver('github')->user();
        // $user->token;
        $github_user_info = [
            'token' => $github_user->token,
            'name' => $github_user->name,
            'id' => $github_user->id,
            'nickname' => $github_user->nickname,
            'email' => $github_user->email,
            'avatar' => $github_user->avatar,
        ];

        //double check t ensure that user who changed his email on github can still access his account here
        if ($user = User::where('github_id', $github_user_info['id'])->first() || $user = User::where('email', $github_user_info['email'])->first()) {
            //user exists
            $user = User::where('github_id', $github_user_info['id'])->first();
        } else {
            // new user
            $user = User::create(
                [
                    'name' => $github_user_info['name'],
                    'email' => $github_user_info['email'],
                    'github_id' => $github_user_info['id']
                ]

            );
        }
        Auth::login($user);

        return redirect('/posts');
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $google_user = Socialite::driver('google')->stateless()->user();
        $google_user_info = [
            'token' => $google_user->token,
            'expiresIn' => $google_user->expiresIn,
            'name' => $google_user->name,
            'id' => $google_user->id,
            'nickname' => $google_user->nickname,
            'email' => $google_user->email,
            'avatar' => $google_user->avatar,
        ];

        //double check t ensure that user who changed his email on github can still access his account here
        // or sign up bofore with another socialmedia account
        if ($user = User::where('google_id', $google_user_info['id'])->first() || $user = User::where('email', $google_user_info['email'])->first()) {
            //user exists
            if(!$user = User::where('google_id', $google_user_info['id'])->first()){
                //user has signned up before with another app using same email, so I log him in his same account
                $user = User::where('email', $google_user_info['email'])->first();
            }else{
                $user = User::where('google_id', $google_user_info['id'])->first() ;
            }
        } else {
            // new user
            $user = User::create(
                [
                    'name' => $google_user_info['name'],
                    'email' => $google_user_info['email'],
                    'google_id' => $google_user_info['id']
                ]
            );
        }
        Auth::login($user);

        return redirect('/posts');
    }
}
