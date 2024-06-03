<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
class CourseController extends Controller
{
    public function showBySchool($school_id)
    {

        $validator = Validator::make(['school_id' => $school_id], [
            'school_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'El ID de la school debe ser un valor numérico.'], 400);
        }
        $curseEntity = new Course();
        $courses =  $curseEntity->getCursesBySchool($school_id);
        return response()->json($courses);
    }
}
