<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    const DEFAULD_PARENT_ID = 1;

    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'level'
    ];

    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getCategoryByQuestionId($questionId)
    {
        return DB::table('categories_questions')
            ->join('categories', 'categories.id', '=', 'categories_questions.category_id')
            ->where('question_id', '=', $questionId)
            ->orderBy('categories.level')
            ->pluck('category_id')->toArray();
    }

    public function insertCategoryQuestion($data)
    {
        DB::table('categories_questions')->insert($data);
    }

    public function clearCategoryQuestion($questionId){
        DB::table('categories_questions')->where('question_id', $questionId)->delete();
    }



}
