<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', \App\Livewire\User\Dashboard::class)->name('dashboard');

    // Attendance Routes
    Route::get('/attendance/check-in', \App\Livewire\Attendance\CheckIn::class)->name('attendance.check-in');
    Route::get('/attendance/history', \App\Livewire\Attendance\History::class)->name('attendance.history');
    Route::get('/attendance/scan', \App\Livewire\QR\ScanQR::class)->name('attendance.scan');

    // Leave Routes
    Route::get('/leave/request', \App\Livewire\Leave\RequestLeave::class)->name('leave.request');
    Route::get('/leave/list', \App\Livewire\Leave\LeaveList::class)->name('leave.list');

    // Notification Route
    Route::get('/notifications', \App\Livewire\User\Notifications::class)->name('notifications');

    // Profile Route
    Route::get('/profile', \App\Livewire\User\Profile::class)->name('profile');

    // Admin Routes
    Route::middleware('can:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
        Route::get('/users', \App\Livewire\Admin\UserManagement::class)->name('admin.users');
        Route::get('/classrooms', \App\Livewire\Admin\ClassroomManagement::class)->name('admin.classrooms');
        Route::get('/leaves', \App\Livewire\Admin\LeaveManagement::class)->name('admin.leaves');
        Route::get('/reports', \App\Livewire\Admin\AttendanceReport::class)->name('admin.reports');
        Route::get('/qr/generate', \App\Livewire\QR\GenerateQR::class)->name('admin.qr.generate');
    });
});
