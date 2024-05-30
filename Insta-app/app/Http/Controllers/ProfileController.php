<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{   
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user', $user);
    }

    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);

        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if($request->avatar){
            $user->avatar ='data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->save();

        return redirect()->route('profile.show', $user->id);
    }
    
        public function updatePassword(Request $request){
        if(!Hash::check($request->oldpassword, Auth::user()->password)){
            return redirect()->back()
                    ->with('current_password_error', 'That is not the current password')
                    ->with('old_password_error', 'That is not the old password')
                    ->with('error_password', 'Unable to change your password');
        }

        if($request->oldpassword === $request->newpassword){
            return redirect()->back()
                    ->with('new_password_error', 'New password cannot be the same as your current password.')
                    ->with('error_password', 'Unable to change your password');
        }

        $request->validate([
            'newpassword' => ['required']
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->newpassword);
        // $request->validate([
        //     'oldpassword' =>'min:8',
        //     'newpassword' =>'min:8',
        //     'confirm' =>'min:8',
            
        //  ]);
        // $user = $this->user->findOrFail(Auth::user()->id);

        // if(!Hash::check($request->oldpassword, Auth::user()->password)){
        //     if($request->newpassword === $request->confirm){
        //         Auth::user()->password = Hash::make($request->newpassword);
        //     }else{
        //         return redirect()->back()
        //                 ->with('new_password_error','New password and Confirm password does not match');
        //     }
        // }else{
        //         return redirect()->back()
        //                 ->with('old_password_error','Old password is not correct');
        // }

         $user->save();

        return redirect()->route('profile.show', $user->id);
    }

    public function follower($id){
        $user = $this->user->findOrFail($id);

        return view('users.profile.followers')
                ->with('user', $user);
    }

    public function following($id){
        $user = $this->user->findOrFail($id);

        return view('users.profile.following')
                ->with('user', $user);
    }
}
