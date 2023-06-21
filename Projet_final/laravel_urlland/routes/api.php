<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;

/*--------------------------------------------------Route des posts-----------------------------------*/

Route::get("/posts", [PostsController::class, 'displayPosts']); //
// Route::get("/filter/posts", [PostsController::class, 'filterResults']);
Route::get("/user/{id}/posts", [PostsController::class, 'userPosts']); //

Route::get("/post/{id}", [PostsController::class, 'displayPost']); //
Route::get("/select/posts", [PostsController::class, 'selectPosts']); //

/*-------Stats------*/
Route::get("/stats/postsByCategory", [PostsController::class, 'getPostsByCategory']); //
Route::get("/stats/postsByUser", [PostsController::class, 'getPostsByUser']); //
Route::get("/stats/numberOf", [PostsController::class, 'getNumberOf']); //
Route::get("/stats/numberTotal", [PostsController::class, 'getTotalConnect']); //
Route::get("/stats/postsByDate", [PostsController::class, 'getPostsByDate']); //

Route::put("/post/{id}", [PostsController::class, 'modifyPost']); //
Route::put("/like/{id}", [PostsController::class, 'addLike']); //
Route::post("/post", [PostsController::class, 'addPost']); //
Route::delete("/post/{id}", [PostsController::class, 'deletePost']); //

/*--------------------------------------------------Route des users -----------------------------------*/

Route::get("/users", [UsersController::class, 'displayUsers']); //
Route::get("/user/{id}", [UsersController::class, 'displayUser']); //
Route::get("/deconnexion", [UsersController::class, 'deconnectUser']); //
Route::get("/user/isadmin/{id}", [UsersController::class, 'verifyIsAdmin']); //

Route::put("/user/{id}", [UsersController::class, 'modifyProfilUser']); //
Route::put("/admin/user", [UsersController::class, 'modifyUser']); //

Route::post("/connexion", [UsersController::class, 'connectUser']); //
Route::post("/user/number/connexion/{id}", [UsersController::class, 'addNumberConnect']); //
Route::post("/admin/user", [UsersController::class, 'addUser']); //
Route::post("/register/user", [UsersController::class, 'registerUser']); //
Route::delete("/user/{id}", [UsersController::class, 'deleteUser']); //

/*--------------------------------------------------Route des comments --------------------------------*/

Route::get("/user/{id}/comments", [CommentsController::class, 'displayCommentsByUser']); //
Route::get("/post/{id}/comments", [CommentsController::class, 'displayCommentsByPost']); //
Route::get("comment/{id}", [CommentsController::class, 'displayComment']); //


Route::put("/comment/{id}", [CommentsController::class, 'modifyComment']); //
Route::post("/comment", [CommentsController::class, 'addComment']); //
Route::delete("/comment/{id}", [CommentsController::class, 'deleteComment']); //
