<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    public function logout()
    {
        // remove tokens for user
        auth()->user()->tokens->each(function ($token){
            $token->delete();
        });

        return response()->json("logged out successfully",200);

    }
    public function me(Request $request)
    {
        $user = $request->user();
        $logins = Login::where('user_id' , $user->id);
        $user->logins = $logins;
        return response()->json($user);
    }
    protected function login(Request $request){
        // first validate the email is passed
        if(!$request->email){
            return response('please provide the email address' , 400);
        }
        // get the user from database
        // if user is null return error
        $user = User::where('email' , $request->email)->first();
        if($user == null){
            return response('please provide valid email address' , 400);
        }
        //prepare for passport oauth request
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
        // this line actually execute the request
        $resp = app()->handle($req);
        $token = json_decode($resp->getContent())->access_token;
        // resp will contain access_token which will be use to verify api requests later
        return $token;
    }

    // verify auth is a simple function makes sure that user token is valid
    // it return true alwayes because if the token is not valid 
    // aut:api middleware will return unauthorized to the cliend
    public function verifyAuth()
    {
        return true;
    }
}
