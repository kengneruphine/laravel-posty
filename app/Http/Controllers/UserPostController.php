<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Like;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function index(user $user){

        //checking user posts
        $posts =$user->posts()->with(['user','likes'])->paginate(20);

        return view('users.posts.index',[
            'user'=>$user,
            'posts'=>$posts
        ]);

    }
}
