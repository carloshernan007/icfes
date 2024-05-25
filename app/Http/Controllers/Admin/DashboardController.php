<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Answer;
use \App\Models\Question;
class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomer = User::all()->count();
        $totalAnwser = Answer::totalAnswer();
        $totalQuestion = Question::all()->count();
        $lastEvaluation = Answer::getLastEvaluation(9);

        return view('admin.dashboard',[
            'totalCustomer' => $totalCustomer,
            'totalAnwser' => $totalAnwser,
            'totalQuestion' => $totalQuestion,
            'lastEvaluation' => $lastEvaluation
        ]);
    }

}
