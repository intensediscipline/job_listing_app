<?php

use App\Models\Applicant;
use Illuminate\Http\Request;
use Database\Seeders\BookmarkSeeder;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::resource('jobs', JobController::class);
Route::resource('jobs', JobController::class)->middleware('auth')->only('create', 'edit', 'update', 'destroy');
Route::resource('jobs', JobController::class)->except('create', 'edit', 'update', 'destroy');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name(name: 'bookmarks.index');
    Route::post('/bookmarks/{job}', [BookmarkController::class, 'store'])->name(name: 'bookmarks.store');
    Route::delete('/bookmarks/{job}', [BookmarkController::class, 'destroy'])->name(name: 'bookmarks.destroy');
    Route::post('/jobs/{job}/apply', [ApplicantController::class, 'store'])->name(name: 'applicant.store');
    Route::delete('/applicants/{applicant}', [ApplicantController::class, 'destroy'])->name(name: 'applicant.destroy');
});