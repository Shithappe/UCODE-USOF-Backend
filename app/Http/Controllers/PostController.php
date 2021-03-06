<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        printf(auth()->user()->id);
        $new_post = Post::create($post_data);

        $categories = (json_decode($request->input('categories')))->id; 
        // return $categories;


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


        if ($post_info == null) {
            return response()->json([
                "error" => [
                    "message"  => "No such post. Post with id $id not found."
                ]
            ], 404); 
        }

        // $post_info->rating = $this->getPostRating($id);
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
        $product = Post::find($id);
        $product->update($request->all());
        return $product;
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
