<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($post_id)
    {
        $comments = Comment::where('post_id', $post_id)->orderBy('created_at')->get();

        $result = array();
        foreach ($comments as $comment) {
            $result[] = $this->show($comment->id);
        }
        return $result;
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
        
        $required = $request->validate([
            'content' => 'required|string',
        ]);
        
        
        $data = [
            'author' => auth()->user()->login,
            'content' => $request->input('content'),
            'post_id' => $post_id
        ];

        return Comment::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment_info = Comment::find($id);
        $comment_info->likes = LikeController::index($id);

        if ($comment_info == null) return  "No comment with id $id";

        return $comment_info;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $request->validate([
            'content' => 'required|string',
        ]);
        $comment = Comment::find($id);
        if($comment['author'] == auth()->user()->login){
        $comment->fill($request)->save();
        return $comment;
        }else return "You can't update other people's commentary";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
