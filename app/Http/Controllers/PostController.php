<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware(['auth'])->only(['store', 'destroy']); // this middleware should apply to store and destroy
    }
    public function index(){
 
        //eager loading data to prevent many queries
        $posts= Post::latest()->with(['user','likes'])->paginate(2);  //to paginate data

        return view('posts.index',[
            'posts'=>$posts
        ]);
    }

   public function show(Post $post){
       return view('posts.show',[
           'post'=>$post
       ]);
   }

    public function store(Request $request){
         $this->validate($request,[
             'body'=>'required'
         ]);

         $request->user()->posts()->create($request->only('body'));

         return back();
    }

    public function destroy(Post $post){
        //check if user is authorize to delete post
        $this->authorize('delete',$post);
        $post->delete();
        return back();
    }
}
