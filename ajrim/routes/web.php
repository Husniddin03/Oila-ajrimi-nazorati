<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TestController;
use App\Http\Controllers\User\ResultController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminTestController;
use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\Admin\AdminResultController;
use App\Http\Controllers\Admin\AdminRecommendationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================
// AUTH ROUTLAR
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============================================================
// FOYDALANUVCHI ROUTLARI
// ============================================================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Testlar
    Route::get('/tests',                    [TestController::class, 'index'])->name('tests.index');
    Route::get('/tests/{test}',             [TestController::class, 'show'])->name('tests.show');
    Route::get('/tests/{test}/start',       [TestController::class, 'start'])->name('tests.start');
    Route::post('/tests/{test}/submit',     [TestController::class, 'submit'])->name('tests.submit');

    // Natijalar
    Route::get('/results',          [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');

    // Profil
    Route::get('/profile',      [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',      [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Bosh sahifa — login yoki dashboard
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// ============================================================
// ADMIN ROUTLARI
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Foydalanuvchilar
    Route::resource('users', AdminUserController::class);
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Testlar
    Route::resource('tests', AdminTestController::class);
    Route::patch('/tests/{test}/toggle-active', [AdminTestController::class, 'toggleActive'])->name('tests.toggle-active');

    // Savollar
    Route::get('/tests/{test}/questions',           [AdminQuestionController::class, 'index'])->name('tests.questions.index');
    Route::get('/tests/{test}/questions/create',    [AdminQuestionController::class, 'create'])->name('tests.questions.create');
    Route::post('/tests/{test}/questions',          [AdminQuestionController::class, 'store'])->name('tests.questions.store');
    Route::get('/tests/{test}/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('tests.questions.edit');
    Route::put('/tests/{test}/questions/{question}',      [AdminQuestionController::class, 'update'])->name('tests.questions.update');
    Route::delete('/tests/{test}/questions/{question}',   [AdminQuestionController::class, 'destroy'])->name('tests.questions.destroy');

    // Natijalar
    Route::get('/results',          [AdminResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [AdminResultController::class, 'show'])->name('results.show');
    Route::delete('/results/{result}', [AdminResultController::class, 'destroy'])->name('results.destroy');

    // Tavsiyalar
    Route::resource('recommendations', AdminRecommendationController::class);
});