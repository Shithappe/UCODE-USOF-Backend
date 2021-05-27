<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\postCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->role == 'admin'){
        $request->validate([
            'title' => 'required|string'
        ]);
        return Category::create($request->all());
        }
        else return "You can`t do it";
    }

    static public function create($category_id, $post_id) {
        $data = [
            'category_id' => $category_id,
            'post_id' => $post_id
        ];
        return PostCategory::create($data);
    }

    static public function getAllPostCategories($post_id) {
        $post_categories_raw = \App\Models\PostCategory::select('category_id as id')->where('post_id', $post_id)->get();
        $post_categories = [];
        for ($i=0; $i < count($post_categories_raw); $i++) {
            $post_categories[$i] = $post_categories_raw[$i]->id;
        }
        return $post_categories;

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->all());
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Category::destroy($id);
    }

    /**
     * search by name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Category::where('title', 'like', '%'.$name.'%')->get();
    }
}
