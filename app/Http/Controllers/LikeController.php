<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index($post_id)
    {
        return Like::where('post_id', $post_id)->get()->count();  // delete ->count() and will be returned all data with author of like
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        if ($like = Like::where('post_id', $post_id)->where('user_id', auth()->user()->id)->first()) return $this->destroy($like, $post_id);// response('awd', 400);//"Like already exists";
                        
        $data = [
            'user_id' => auth()->user()->id,
            'post_id' => $post_id
        ];
        $post = Post::find($post_id);
        $user = User::find($post->user_id);
        $user->rating = $user->rating + 1;
        $user->save();
        
        return Like::create($data);
    }

    public function add_like_comment(Request $request, $comment_id)
    {
        if ($like = Like::where('comment_id', $comment_id)->where('user_id', auth()->user()->id)->first()) return "Like already exists";
                        
        $data = [
            'user_id' => auth()->user()->id,
            'comment_id' => $comment_id
        ];
        $comment = Comment::find($comment_id);
        $user = User::where('login', $comment->author)->first();
        $user->rating = $user->rating + 1;
        $user->save();
        
        return Like::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like, $post_id)
    {   
        if ($like = Like::where('post_id', $post_id)->where('user_id', auth()->user()->id)->first()) 
        return Like::destroy($like['id']);              
    }

    // public function delete($user_id, $post_id)
    // {   
    //     if ($like = Like::where('post_id', $post_id)->where('user_id', $user_id)->first()) 
    //     return Like::destroy($like['id']);              
    // }
}
