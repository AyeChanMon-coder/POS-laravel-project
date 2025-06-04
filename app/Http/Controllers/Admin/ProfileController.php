<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }
    public function profileEdit(){
        return view('admin.profile.profileEditPage');
    }

    /**
     * Update the user's profile information.
     */

    public function profileUpdate(Request $request){
        $this->checkValidation($request);
        $data = $this->getData($request);
        if($request->hasFile('image')){
            if(Auth::user()->profile != null){
                if(file_exists(public_path('profile/') . Auth::user()->profile)){
                    unlink( public_path('profile/') . Auth::user()->profile);
                }
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move( public_path() . '/profile/' , $fileName);
            $data['profile'] = $fileName;
        }
        User::where('id',Auth::user()->id)->update($data);
        Alert::success('Success Title','Product updated successfully');
        return back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    //process change process
    public function changePasswordProcess(Request $request){
        $registeredPassword = Auth::user()->password; //hash value
        if(Hash::check($request->oldPassword, $registeredPassword)){
            $this->checkPassword($request);
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Alert::success('Success Title','Password Updated Successfully!');
            return back();
        }else{
            Alert::error('Error Title','Your old password does not match credentials! Try again');
            return back();
        }
    }
    //password change page
    public function changePassword(){
        return view('admin.profile.changePassword');
    }
    //check profile form data
    private function checkValidation($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|max:30|unique:users,email,'.Auth::user()->id,
            'image' => 'file',
        ]);
    }
    //get profile form data
    private function getData($request){
        return[
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
    }
    //check password validation
    private function checkPassword($request){
            $request->validate([
                'oldPassword' => 'required',
                'newPassword' => 'required|min:6|max:12',
                'confirmPassword' => 'required|same:newPassword',
            ]);
    }
}
