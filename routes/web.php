<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/search', [UserSearchController::class, 'index'])->name('search.index');
    Route::post('/search', [UserSearchController::class, 'search'])->name('search.perform');

    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/friends/request/{friendId}', [FriendshipController::class, 'sendRequest'])->name('friends.request');
    Route::post('/friends/accept/{friendshipId}', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/reject/{friendshipId}', [FriendshipController::class, 'rejectRequest'])->name('friends.reject');
    Route::get('/friends/search', [FriendshipController::class, 'search'])->name('friends.search');
    Route::get('/friends/requests', [FriendshipController::class, 'pendingRequests'])->name('friends.requests');
    Route::get('/friends', [FriendshipController::class, 'friendsList'])->name('friends.list');
    Route::get('/friends/{id}', [FriendshipController::class, 'show'])->name('friends.show');
});
Route::get('/posts/friendsPosts', [PostController::class, 'friendsPosts'])->name('posts.friendsPosts');

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
});

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike'])->name('posts.like');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);


Route::get('/add-friend/{user}', [FriendshipController::class, 'addFriendFromQr'])->name('addFriendFromQr');

Route::get('/addfriend', function () {
    return "added";
})->name('addFriendQr');

Route::get('/auth/facebook', [SocialiteController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);

