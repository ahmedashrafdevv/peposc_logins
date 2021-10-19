<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
class UserController extends Controller
{
    public function redirect($provider)
    {
        $url = Socialite::driver($provider)->redirect();
        return $url->getTargetUrl();
    }


    // this function will be called after provider loggin user in
    // provivder param is one if ['google' , 'facebook; , 'micorsoft']
    // and socialite will be able to access data from user account on the provider website
    public function callback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        //check if user alread exists
        // if not create new user with data from provider
        $user = User::where('email', $providerUser->getEmail())->first();
        if ($user == null) {
            $user = $this->_createUser($providerUser);
        }
        // prepare login record
        // and create record to be able to show the user data about his login history
        $login = [
            "provider_id" => $providerUser->getId(),
            "user_id" => $user->id,
            "provider" => $provider
        ];
        Login::create($login);
        // call login to get access token
        $token = $this->_login($user->email);
        // and finally redirect to the vue app again in login route which will perform login request
        // and save the token in localstorge
        $appUrl = env('APP_URL');
        $redirecUrl = $appUrl . 'login/' . $token;
        return redirect()->to($redirecUrl);
    }

    private function _login($email)
    {
        $passwordGrantClient = Client::find(env('PASSPORT_CLIENT_ID', 2));

        // prepare data to call passport endpoint
        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $email,
            'password' => 'default',
            'scope' => '*',
        ];
        $req = Request::create('oauth/token' , 'post', $data );
        // this line executes the request
        $resp = app()->handle($req);
        return json_decode($resp->getContent())->access_token;
    }

    
    public function viewUsers($status)
    {
        $users = User::where('status' , $status)->get();
        return response($users);
    }
   
    public function verifyUser($id , $status){
        $user = User::find($id);
        $user->status = $status;
        $user->save();
        return response()->ok();
    }
    private function _createUser($user)
    {
        // we set password to default because i need the field to login with passport

        return User::Create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' =>bcrypt('default'),
            'avatar' => $user->getAvatar()
        ]);
    }
}