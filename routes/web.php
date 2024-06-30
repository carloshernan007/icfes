<?php

use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\Admin\DashboardController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\CourseController;
use \App\Http\Controllers\Admin\SchoolController;
use \App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Admin\QuestionController;
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
        ->middleware('permission:create course');

    Route::post('/school/create',[CourseController::class, 'create'])
        ->name('admin.school.create')
        ->middleware('permission:create course');

    Route::get('/course/edit/{course_id}/',[CourseController::class, 'edit'])
        ->name('admin.course.edit')
        ->middleware('permission:edit course');

    Route::get('/course/assignment/{course_id}/',[CourseController::class, 'assignment'])
        ->name('admin.course.assignment')
        ->middleware('permission:edit course');

    Route::post('/course/assignment',[CourseController::class, 'assignmentCreate'])
        ->name('admin.course.assignment.save')
        ->middleware('permission:edit course');


    Route::get('/course/delete/{course_id}/',[CourseController::class, 'remove'])
        ->name('admin.course.delete')
        ->middleware('permission:delete course');


    Route::get('/category',[CategoryController::class, 'index'])
        ->name('admin.category')
        ->middleware('permission:list category');

    Route::get('/category/create',[CategoryController::class, 'create'])
        ->name('admin.category.create')
        ->middleware('permission:create category');

    Route::post('/category/create',[CategoryController::class, 'create'])
        ->name('admin.category.create')
        ->middleware('permission:create category');

    Route::get('/category/edit/{category_id}/',[CategoryController::class, 'edit'])
        ->name('admin.category.edit')
        ->middleware('permission:edit course');

    Route::get('/category/assignment/{category_id}/',[CategoryController::class, 'assignment'])
        ->name('admin.category.assignment')
        ->middleware('permission:edit category');

    Route::post('/category/assignment',[CategoryController::class, 'assignmentCreate'])
        ->name('admin.category.assignment.save')
        ->middleware('permission:edit category');


    Route::get('/category/delete/{category_id}/',[CategoryController::class, 'remove'])
        ->name('admin.category.delete')
        ->middleware('permission:delete category');


    Route::get('/question',[QuestionController::class, 'index'])
        ->name('admin.question')
        ->middleware('permission:list question');

    Route::get('/question/create',[QuestionController::class, 'create'])
        ->name('admin.question.create')
        ->middleware('permission:create question');

    Route::post('/question/create',[QuestionController::class, 'create'])
        ->name('admin.question.create')
        ->middleware('permission:create question');

    Route::get('/question/edit/{question_id}/',[QuestionController::class, 'edit'])
        ->name('admin.question.edit')
        ->middleware('permission:edit question');

    Route::get('/question/delete/{question_id}/',[QuestionController::class, 'remove'])
        ->name('admin.question.delete')
        ->middleware('permission:delete question');


    Route::get('/question/status/{question_id}/',[QuestionController::class, 'status'])
        ->name('admin.question.status')
        ->middleware('permission:edit question');


    Route::post('/question/upload_image', [QuestionController::class, 'uploadImage'])
        ->name('admin.question.image')
        ->middleware('permission:create question');


});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
