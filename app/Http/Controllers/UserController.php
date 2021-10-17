<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
   public function googleRedirect(Request $request)
   {
        return Socialite::driver('google')->redirect();

    //    dd($request->all());
   }


   public function googleCallBack(Request $request)
   {
        $user = Socialite::driver('google')->user();
        dd($user);

    //    dd($request->all());
   }

   public function facebookRedirect(Request $request)
   {
        return Socialite::driver('facebook')->redirect();

    //    dd($request->all());
   }


   public function facebookCallBack(Request $request)
   {
        $user = Socialite::driver('facebook')->user();
        dd($user);

    //    dd($request->all());
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