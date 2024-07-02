<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpcomingEventController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/events/upcoming-events', [UpcomingEventController::class, 'index'])->name('upcoming-events');
    Route::get('/events/{event}/join', [UpcomingEventController::class, 'join'])->name('join-event');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/events/{event}', [HomeController::class, 'showEvent'])->name('home.show-event');

Route::middleware('auth', 'role:2')->group(function () {
    Route::get('/dashboard-user/profile', [\App\Http\Controllers\Member\ProfileController::class, 'show'])->name('member.profile.show');
    Route::patch('/dashboard-user/profile', [\App\Http\Controllers\Member\ProfileController::class, 'update'])->name('member.profile.update');
    Route::delete('/dashboard-user/profile', [\App\Http\Controllers\Member\ProfileController::class, 'destroy'])->name('member.profile.destroy');
});


Route::middleware('auth', 'role:1')->group(function () {
    Route::get('/dashboard-admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('admin.profile.show');
    Route::patch('/dashboard-admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/dashboard-admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    Route::get('/dashboard-admin', DashboardController::class)->name('dashboard-admin');

    Route::get('/dashboard-admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::delete('/dashboard-admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/dashboard-admin/users/{user}/ban', [UserManagementController::class, 'ban'])->name('admin.users.ban');

    Route::get('/dashboard-admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/dashboard-admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/dashboard-admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/dashboard-admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::patch('/dashboard-admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/dashboard-admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/dashboard-admin/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/dashboard-admin/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/dashboard-admin/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/dashboard-admin/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::patch('/dashboard-admin/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/dashboard-admin/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    Route::get('/dashboard-admin/events/{event}/publish', [EventController::class, 'publish'])->name('admin.events.publish');
});

require __DIR__.'/auth.php';
