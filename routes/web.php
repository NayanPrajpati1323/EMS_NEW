<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Auth\ForgotPasswordController;

// ✅ Public pages

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

 
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ✅ Protected pages
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('dashboard'); // ✅ No redirect loop
    })->name('dashboard');
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

    Route::resource('employees', EmployeesController::class);
    Route::get('/employee_details/{id}', [EmployeesController::class, 'employeesDetails'])->name('employee_details');
    

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
Route::post('/forgot-password/send', [LoginController::class, 'sendForgotPasswordOTP'])->name('forgot-password.send');
Route::post('/password/reset', [LoginController::class, 'resetPassword'])->name('password.reset');
