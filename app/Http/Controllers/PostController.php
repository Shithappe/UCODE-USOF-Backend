<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $result = array();
        foreach ($posts as $post) {
            if ($post['status'] == 'active')
            $result[] = $this->show($post->id);
        }
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'categories' => 'required|json'
        ]);
        $title = $request->input('title');
        $content = $request->input('content');
        
        $post_data = ['author' => auth()->user()->login,
                 'user_id' => auth()->user()->id,
                 'title' => $title,
                 'content' => $content];

        $new_post = Post::create($post_data);

        $categories = (json_decode($request->input('categories')))->id; 

        foreach ($categories as $category) {
            if(\App\Models\Category::find($category)) {
                CategoryController::create($category, $new_post->id);
            }
        }
        
        return $this->show($new_post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post_info = Post::find($id);
        if ($post_info == null) return response('Not found', 404); 
        $post_info->categories = CategoryController::getAllPostCategories($id);

        return $post_info;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (auth()->user()->login == $post['author']){
        $post->update($request->all());
        return $post;}
        else return "You can't update this";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::destroy($id);
    }
}
