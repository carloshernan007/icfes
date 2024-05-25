<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
class Answer extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Calculate total answers
     * @return int
     */
    public static function totalAnswer():int{
         $row =  self::select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->get();
         return (!empty($row[0])) ? $row[0]->total : 0;
    }

    /**
     * Last 20 evaluations
     * @return \Illuminate\Support\Collection
     */
    public static function getLastEvaluation()
    {
        return  DB::table('users as u')
            ->join('registers as r', 'u.id', '=', 'r.user_id')
            ->join('answers as a', 'u.id', '=', 'a.user_id')
            ->join('courses as c', 'c.id', '=', 'a.course_id')
            ->select(
                'u.id',
                        'u.name',
                        'r.fullname',
                        'c.name as course_name',
                        'c.id as course_id',
                        DB::raw('DATE_FORMAT(a.created_at, "%Y-%m-%d") as created_date')
            )
            ->groupBy(['u.id', 'u.name', 'r.fullname', 'c.name', 'c.id','created_date'])
            ->orderBy('a.created_at', 'desc')
            ->limit(20)
            ->get();
    }
}
