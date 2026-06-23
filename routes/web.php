<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueTagController;
use App\Http\Controllers\IssueUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

Route::middleware('guest')->group(function (): void {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.store');
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::resource('projects', ProjectController::class)->only(['index']);
Route::resource('projects', ProjectController::class)
    ->except(['index', 'show'])
    ->middleware('auth');
Route::resource('projects', ProjectController::class)->only(['show']);
Route::resource('issues', IssueController::class);

Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');

Route::post('issues/{issue}/tags', [IssueTagController::class, 'attach'])->name('issues.tags.attach');
Route::delete('issues/{issue}/tags/{tag}', [IssueTagController::class, 'detach'])->name('issues.tags.detach');

Route::post('issues/{issue}/users', [IssueUserController::class, 'attach'])->name('issues.users.attach');
Route::delete('issues/{issue}/users/{user}', [IssueUserController::class, 'detach'])->name('issues.users.detach');

Route::get('issues/{issue}/comments', [CommentController::class, 'index'])->name('issues.comments.index');
Route::post('issues/{issue}/comments', [CommentController::class, 'store'])->name('issues.comments.store');
