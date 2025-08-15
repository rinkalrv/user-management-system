<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\ValidateSignature;
use App\Http\Controllers\Auth\LoginController; // Update this import
use App\Http\Controllers\ProfileController;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes(['verify' => false]); // We're handling verification manually

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/activate/{token}', [RegisterController::class, 'activate'])->name('activate');
Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
    ->name('users.toggle-status')
    ->middleware(['auth', 'can:manage-users']);

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify')
    ->middleware(['signed']);    

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth'])
    ->name('verification.resend');

// User management routes (protected by auth middleware)
Route::middleware(['auth', 'verified'])->group(function () {
    // User CRUD
    Route::resource('users', UserController::class);
    
    // Sub User Module
    Route::resource('sub-users', SubUserController::class);
    
    // Category Management
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category'
    ]);    
    // Product Management
    Route::resource('products', ProductController::class);

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

