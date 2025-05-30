<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Homepage shows article list
Route::get('/', [ArticleController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Article routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Comment routes
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

// User comment management routes
Route::middleware('auth')->group(function () {
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Newsletter subscription route
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

// Admin routes - protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Article management
    Route::get('/articles', [AdminController::class, 'articles'])->name('articles');
    Route::get('/articles/create', [AdminController::class, 'createArticle'])->name('articles.create');
    Route::post('/articles', [AdminController::class, 'storeArticle'])->name('articles.store');
    Route::get('/articles/{article}/edit', [AdminController::class, 'editArticle'])->name('articles.edit');
    Route::put('/articles/{article}', [AdminController::class, 'updateArticle'])->name('articles.update');
    Route::delete('/articles/{article}', [AdminController::class, 'destroyArticle'])->name('articles.destroy');
    
    // Comment management
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments');
    Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('comments.destroy');
    
    // Newsletter management
    Route::get('/subscribers', [AdminController::class, 'subscribers'])->name('subscribers');
    Route::post('/subscribers', [AdminController::class, 'storeSubscriber'])->name('subscribers.store');
    Route::delete('/subscribers/{subscriber}', [AdminController::class, 'destroySubscriber'])->name('subscribers.destroy');
    
    // Ad management
    Route::resource('ads', AdController::class);
});

// Test route for admin access
Route::get('/test-admin', function () {
    return view('test-admin');
})->name('test.admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
