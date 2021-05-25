<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/w', function () {
    // return "view('welcome');";

    $authors = \App\Models\Author::all();

    foreach ($authors as $author){
        echo '<b>Author name: ' . $author['name'] . '</b>' . '<br>';
        foreach ($author->books as $book){
            echo $book['title'] . '<br>';
        }
        echo '---------------<br>';
    }
});