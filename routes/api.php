<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/events', [EventController::class, 'index'])->name('api.events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->where('id', '[0-9]+')->name('api.events.show');
Route::post('/comment', [CommentController::class, 'store'])->middleware('auth')->name('api.comments.store');
Route::post('/events/{event}/toggle-participation', [EventController::class, 'toggleParticipation'])->middleware('auth')->name('events.toggleParticipation');
Route::get('/user/events', [EventController::class, 'userEvents'])->middleware('auth')->name('api.user.events');
Route::get('/user/comments', [CommentController::class, 'userComments'])->middleware('auth')->name('api.user.comments');
