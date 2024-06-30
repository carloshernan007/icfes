<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'description'
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    static function insertCourseQuestion($data)
    {
        DB::table('courses_questions')->insert($data);
    }

    public function clearCourseQuestion($questionId){
        DB::table('courses_questions')->where('question_id', $questionId)->delete();
    }
}
