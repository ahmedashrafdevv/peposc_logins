<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function redirect($provider)
    {
        $err = $this->_validateProvider($provider);
        if ($err !== null) {
            return response($err, 400);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        // validate that provider is on of our three allowed providers
        $err = $this->_validateProvider($provider);
        if ($err !== null) {
            return response($err, 400);
        }
        $providerUser = Socialite::driver('google')->user();
        //check if user alread exists
        $user = User::where('email', $providerUser->getEmail())->first();
        if ($user == null) {
            $user = $this->_createUser($providerUser);
        }
        $login = [
            "provider_id" => $providerUser->getId(),
            "user_id" => $user->id,
            "provider" => $provider
        ];
        Login::create($login);


        return redirect('/');
    }

    
    public function viewLogins($status)
    {
        $logins = Login::get();
        return response($logins);
    }

    public function verifyLogin($login)
    {
        $login = Login::where('id' , $login);
        $user = $login->user();
        // auth()->login($user, true);
        return response($user);
    }
    private function _validateProvider($provider): ?string
    {
        $avilableProviders = ['facebook', 'google', 'microsoft'];
        if (!in_array($provider, $avilableProviders)) {
            return 'unsupported provider';
        }
        return null;
    }
    private function _createUser($user)
    {
        return User::Create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar()
        ]);
    }
}




//    try {
//     $user = Socialite::driver('google')->user();
// } catch (\Exception $e) {
//     return redirect('/login');
// }
// // only allow people with @company.com to login
// if(explode("@", $user->email)[1] !== 'company.com'){
//     return redirect()->to('/');
// }
// // check if they're an existing user
// $existingUser = User::where('email', $user->email)->first();
// if($existingUser){
//     // log them in
//     auth()->login($existingUser, true);
// } else {
//     // create a new user
//     $newUser                  = new User;
//     $newUser->name            = $user->name;
//     $newUser->email           = $user->email;
//     $newUser->google_id       = $user->id;
//     $newUser->avatar          = $user->avatar;
//     $newUser->avatar_original = $user->avatar_original;
//     $newUser->save();
//     auth()->login($newUser, true);
// }
// return redirect()->to('/home');