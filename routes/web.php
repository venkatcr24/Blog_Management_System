<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogController::class, 'publicIndex'])
    ->name('home');

Route::get('/blogs', [BlogController::class, 'publicIndex'])
    ->name('blogs.public');

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'store'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'authenticate'])
        ->name('login.authenticate');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/blogs/manage', [BlogController::class, 'index'])
        ->name('blogs.index');

    Route::get('/blogs/create', [BlogController::class, 'create'])
        ->name('blogs.create');

    Route::post('/blogs', [BlogController::class, 'store'])
        ->name('blogs.store');

    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])
        ->name('blogs.edit');

    Route::put('/blogs/{blog}', [BlogController::class, 'update'])
        ->name('blogs.update');

    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])
        ->name('blogs.destroy');
});

Route::get('/blogs/{blog}', [BlogController::class, 'show'])
    ->name('blogs.show');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('admin.dashboard');

        Route::patch(
            '/blogs/{blog}/approve',
            [BlogController::class, 'approve']
        )->name('blogs.approve');

        Route::patch(
            '/blogs/{blog}/reject',
            [BlogController::class, 'reject']
        )->name('blogs.reject');

        Route::resource('categories', CategoryController::class);
    });