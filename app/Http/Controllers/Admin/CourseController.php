<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(){

        $rows = Course::leftJoin('courses_schools', 'courses.id', '=', 'courses_schools.course_id')
            ->select('courses.name as name',
                     'courses.created_at as created_at',
                     'courses.id as id',
            )

            ->selectRaw('count(courses_schools.course_id) as school_count')
            ->groupBy(['courses.id','courses.name','courses.created_at'])
            ->orderBy('courses.name', 'desc')
            ->paginate(20);
        return view('admin.course.course', compact('rows'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'name' => ['required','string','max:100', Rule::unique('courses')->ignore($request->id),],
            ]);
            try {
                if(empty($request->id)) {
                    $course = Course::create([
                        'name' => $request->name,
                    ]);
                    session()->flash('success', __('course.message-add'));
                }else{
                    $course = Course::find($request->id);
                    foreach (['name'] as $field) {
                        $course->$field = $request->$field;
                    }
                    $course->save();
                    session()->flash('success', __('course.message-update'));
                }
                return redirect()->route('admin.course');
            }catch (\Exception $exception){
                session()->flash('danger', $exception->getMessage());
            }
        }
        return view('admin.course.form');
    }

    public function edit($id){

        $course = Course::find($id);
        if(!$course){
            session()->flash('danger', __('courses.message-course-not-found'));
            return redirect()->route('admin.courses');
        }
        return view('admin.course.form',
            compact( 'course' )
        );
    }

    public function assignment($id){

        $course = Course::find($id);
        if(!$course){
            session()->flash('danger', __('courses.message-course-not-found'));
            return redirect()->route('admin.courses');
        }

        $courseEntity = new Course();
        $schools = School::all()->sortBy('name');
        $schoolActive = $courseEntity->getSchoolBycourseId($id);
        return view('admin.course.assignment',
            compact( 'course','schools','schoolActive' )
        );
    }

    public function assignmentCreate(Request $request){
        $courseEntity = new Course();
        $courseEntity->removeCourse($request->id);
        foreach ($request->school_id as $row) {
            $courseEntity->insertCourseSchool([
                'course_id' => $request->id,
                'school_id' => $row,
            ]);
        }
        session()->flash('success', __('course.message-school'));
        return redirect()->route('admin.course');
    }

    public function remove($id){
        $course = Course::find($id);
        $status = 'ok';
        if(!$course){
            $message = __('school.message-school-not-found');
            $status = 'error';
        }else{

            if(!$course->hasRelatedRegisters($id)){
                $course->delete();
                $message = __('course.message-delete',['curso' => $course->name]);
                $status = 'error';
            }else{
                $message = __('course.message-delete-warning',['curso' => $course->name]);
            }
        }
        return response()->json([
            'message' => $message,
            'title' => __('course.label-deleted'),
            'status' => $status
        ]);
    }
}
