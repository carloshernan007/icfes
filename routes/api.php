<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CityController;

Route::get('city/{region_id}', [CityController::class, 'showByRegion'])->name('showByRegion');;
Route::get('course/{school_id}', [CourseController::class, 'showBySchool'])->name('showBySchool');;