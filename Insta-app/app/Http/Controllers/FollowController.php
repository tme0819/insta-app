<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    private $follow;
    private $user;

    public function __construct(Follow $follow, User $user){
        $this->follow = $follow;
        $this->user =  $user;
    }

    public function store($user_id){
        $id = Auth::user()->id;
       
        $this->follow->follower_id = $id;
        $this->follow->following_id = $user_id;

        $this->follow->save();
        return back();
    }

    public function destroy($user_id){
        $this->follow
                ->where('follower_id', Auth::user()->id)
                ->where('following_id', $user_id)
                ->delete();

        return redirect()->back();
    }

}
