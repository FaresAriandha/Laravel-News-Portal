<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home', [
        "title" => "Home"
    ]);
});

Route::get('/about', function () {
    return view('about', [
        "title" => "About",
        "name" => "Fares Ariandha",
        "NIM" => "2107411020",
        "email" => "fares@gmail.com"
    ]);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post:slug}', [PostController::class, 'singlePost']);
Route::get('/categories', function () {
    return view('categories', [
        'title' => 'Categories',
        'categories' => Category::all()
    ]);
});

// Login and Registration
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('google.redirect');
Route::get('/google/redirect', [LoginController::class, 'googleCallback'])->name('google.callback');

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');

Route::get('/dashboard/posts/createSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

// Crud Posts
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

// CRUD categories
Route::get('/dashboard/categories/createSlug', [AdminCategoryController::class, 'checkSlug'])->middleware(['is_admin', 'auth']);
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware(['is_admin', 'auth']);
