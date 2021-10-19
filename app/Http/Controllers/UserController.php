<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function logout()
    {
        auth()->user()->tokens->each(function ($token){
            $token->delete();
        });

        return response()->json("logged out successfully",200);

    }
    public function me(Request $request)
    {
        $user = User::with('logins')->find($request->user()->id);
        // $phones = Phone::where('AccSerial' , $request->user()->id)->select(['phone' , 'id'])->get();
        // $user->phones = $phones;
        // dd($request->user()->phones->pluck('Phone')->flatten());
        // dd($user);
        return response()->json($user);
    }
    protected function login(Request $request){
        if(!$request->email){
            return response('please provide the email address' , 400);
        }
        $user = User::where('email' , $request->email)->first();
        if($user == null){
            return response('please provide valid email address' , 400);
        }
        $passwordGrantClient = Client::find(env('PASSPORT_CLIENT_ID', 2));
        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $request->email,
            'password' => 'default',
            'scope' => '*',
        ];

        $req = Request::create('oauth/token' , 'post', $data );
        $resp = app()->handle($req);
        return $resp;
    }
    public function verifyAuth()
    {
        return true;
    }
    public function redirect($provider)
    {
        $err = $this->_validateProvider($provider);
        if ($err !== null) {
            return response($err, 400);
        }
        $url = Socialite::driver($provider)->redirect();
        return $url->getTargetUrl();
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
        return redirect()->to(url("$user->email/login"));
    }

    
    public function viewUsers($status)
    {
        $users = User::where('status' , $status)->get();
        return response($users);
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
    public function verifyUser($id , $status){
        $user = User::find($id);
        $user->status = $status;
        $user->save();
        return response('decliened');
    }


    public function approveLogin($login){

    }
    
    
    private function _createUser($user)
    {
        return User::Create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' =>bcrypt('default'),
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