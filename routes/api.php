<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//  Public
Route::post('/auth/register', [AuthController::class, 'register']);                     // Register user
Route::post('/auth/login', [AuthController::class, 'login']);                           // Log in
Route::post('/auth/reset', [MailController::class, 'sendEmail']);                       // Reset password

Route::get('/users/{id}', [UserController::class, 'show']);                             // Show user by id

Route::get('/posts', [PostController::class, 'index']);                                 // Show all posts
Route::get('/post/{id}', [PostController::class, 'show']);                              // Show posts by id
Route::get('/post/seach/{name}', [ProductController::class, 'search']);                 // Search post by name

Route::get('/categories', [CategoryController::class, 'index']);                        // Show all categories
Route::get('/categories/{id}', [CategoryController::class, 'show']);                    // Show category by id
Route::get('/categories/seach/{name}', [CategoryController::class, 'search']);          // Search category by title

Route::get('/posts/{id}/comments', [CommentController::class, 'index']);                // Show all comments of post
Route::get('/posts/{id}/likes', [LikeController::class, 'index']);                      // Show coutn likes of post



Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/seach/{name}', [ProductController::class, 'search']);


// Private
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);                     // Log out
    Route::post('/auth/reset_pass', [AuthController::class, 'reset_pass']);             // Change password

    Route::get('/users', [UserController::class, 'index']);                             // Show all users
    Route::patch('/users/{id}', [UserController::class, 'update']);                     // Update user date by id
    Route::delete('/users/{id}', [UserController::class, 'destroy']);                   // Delete user


    Route::post('/posts', [PostController::class, 'store']);                            // Add post
    Route::patch('/posts/{id}', [PostController::class, 'update']);                     // Update post
    Route::get('/user_posts/{id}', [PostController::class, 'getUserPost']);             //-----------------------------------
    Route::post('/categories', [CategoryController::class, 'store']);                   // Add category

    Route::patch('/categories/{id}', [CategoryController::class, 'update']);            // Update category date by id
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);          // Delete category

 
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);           // Add comment to post
    Route::patch('/comments/{id}', [CommentController::class, 'update']);               // Update comment
    Route::post('/posts/{id}/likes', [LikeController::class, 'store']);                 // Add like to post
    Route::delete('/posts/{id}/likes', [LikeController::class, 'destroy']);             // Delete like 

    Route::get('/products/seach/{name}', [ProductController::class, 'search']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});