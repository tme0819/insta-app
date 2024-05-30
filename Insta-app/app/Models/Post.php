<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
    
    #Post has many CategoryPost
    #To get all the categories of a post
    #Use this to save categories of the post
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    # To get all the comments of a post
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    #Returns True if the Auth user has already liked the post
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
