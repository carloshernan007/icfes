<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \App\Models\Register;

class Course extends Model
{
    use HasFactory;

    static function insertCourse($data)
    {
        DB::table('courses_users')->insert($data);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

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


    public function getSchoolBycourseId($courseId)
    {
        return DB::table('courses_schools')
            ->where('course_id', '=', $courseId)
            ->pluck('school_id')->toArray();
    }


    public function hasRelatedRegisters($id)
    {
        return DB::table('courses_users')
            ->where('course_id', '=', $id)
            ->count() > 0;
    }

    public function removeCourse($id)
    {
        DB::table('courses_schools')
            ->where('course_id','=',$id)
            ->delete();
    }

    static function insertCourseSchool($data)
    {
        DB::table('courses_schools')->insert($data);
    }




    public function getCourseByQuestionId($questionId)
    {
        return DB::table('courses_questions')
            ->where('question_id', '=', $questionId)
            ->pluck('course_id')->toArray();
    }


}
