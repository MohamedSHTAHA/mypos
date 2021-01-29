<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/dashboard/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $getInfo = Socialite::driver($provider)->user();

            $account = SocialAccount::where('provider', $provider)->where('provider_user_id', $getInfo->getId())->first();
            if ($account) {
                $user = $account->user;
            } else {
                $akun =  new SocialAccount([
                    'provider_user_id' => $getInfo->getId(),
                    'provider' => $provider,
                ]);
                $orang = User::where('email', $getInfo->getEmail())->first();
                if (!$orang) {
                    $orang = User::create([
                        'first_name' => $getInfo->getName(),
                        'last_name' => $getInfo->getNickname(),
                        'email' => $getInfo->getEmail(),
                        'verified' => 1,
                        'password' => '',
                        //'image' => $getInfo->getAvatar(),

                    ]);
                }
                $akun->user()->associate($orang);
                $akun->save();
                $user = $orang;
            }
            auth()->login($user);
            return redirect()->to('/');
        } catch (Exception $e) {
            return redirect('/');
        }
    }
}
