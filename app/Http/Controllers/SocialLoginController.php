<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
        $socialUser = Socialite::driver($provider)->user();
        $avatarUrl = $socialUser->getAvatar();
        //save image to public folder
        $filename = $socialUser->getId() . '.jpg'; // or use Str::uuid() if you want
        $folder = 'profile/';
        $path = public_path($folder . $filename);
        //fetch image and store
        $imageContents = file_get_contents($avatarUrl);
        file_put_contents($path, $imageContents);
        $user = User::updateOrCreate([
            'provider_id' => $socialUser->id
        ],[
            'name' => $socialUser->name,
            'nickname' => $socialUser->nickname,
            'email' => $socialUser->email,
            'role' => 'user',
            'profile' => $filename,
            'provider' => $provider,
            'provider_id' => $socialUser->id,
            'provider_token' => $socialUser->token,
        ]);
        Auth::login($user);
        return to_route('user#home');
    }
    private function addAvatar($provider){
        $socialUser = Socialite::driver($provider)->user();
        //get image url


    }
}
