<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Course extends Model
{
    use HasFactory;

    static function insertCourse($data)
    {
        DB::table('courses_users')->insert($data);
    }
}
