<?php

use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\Admin\DashboardController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\CourseController;
use \App\Http\Controllers\Admin\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';


//Administrator

/**
 * 'create user',
 * 'delete user',
 * 'edit user',
 * 'list user',
 * 'create school',
 * 'delete school',
 * 'edit school',
 * 'create course',
 * 'delete course',
 * 'edit course',
 * 'setting',
 * 'delete evaluation',
 **/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('permission:view report');

    Route::get('/users',[UserController::class, 'index'])
        ->name('admin.user')
        ->middleware('permission:list user');

    Route::get('/users/create',[UserController::class, 'create'])
        ->name('admin.user.create')
        ->middleware('permission:create user');

    Route::post('/users/store',[UserController::class, 'store'])
        ->name('admin.user.store')
        ->middleware('permission:create user');

    Route::get('/users/edit/{user_id}/',[UserController::class, 'edit'])
        ->name('admin.user.edit')
        ->middleware('permission:edit user');


    Route::get('/school',[SchoolController::class, 'index'])
        ->name('admin.school')
        ->middleware('permission:list school');

    Route::get('/school/create',[SchoolController::class, 'create'])
        ->name('admin.school.create')
        ->middleware('permission:create school');

    Route::post('/school/create',[SchoolController::class, 'create'])
        ->name('admin.school.create')
        ->middleware('permission:create school');

    Route::get('/school/edit/{school_id}/',[SchoolController::class, 'edit'])
        ->name('admin.school.edit')
        ->middleware('permission:edit school');

    Route::get('/school/delete/{school_id}/',[SchoolController::class, 'remove'])
        ->name('admin.school.delete')
        ->middleware('permission:delete school');


    Route::get('/course',[CourseController::class, 'index'])
        ->name('admin.course')
        ->middleware('permission:list course');

    Route::get('/course/create',[CourseController::class, 'create'])
        ->name('admin.course.create')
        ->middleware('permission:create source');

    Route::post('/course/save',[CourseController::class, 'save'])
        ->name('admin.course.save')
        ->middleware('permission:create course');

    Route::post('/course/edit',[UserController::class, 'edit'])
        ->name('admin.course.edit')
        ->middleware('permission:edit source');

});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
