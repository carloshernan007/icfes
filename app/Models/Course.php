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

    /**
     * Get all curses of user
     *
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public function getCursesByUserId($userId)
    {
        return DB::table('courses_users')
            ->where('user_id', '=', $userId)
            ->pluck('course_id')->toArray();
    }

    public function getCursesBySchool($school_id)
    {
        return Course::join('courses_schools', 'courses.id', '=', 'courses_schools.course_id')
            ->where('courses_schools.school_id', $school_id)
            ->orderBy('name', 'asc')
            ->get();
    }
}
