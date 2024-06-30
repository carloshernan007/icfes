<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Option;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
class QuestionController extends Controller
{

    public function index()
    {
        $rows = Question::leftJoin('courses_questions as q', 'q.question_id', '=', 'questions.id')
            ->select('questions.id as question_id',
                'questions.description as description',
                'questions.created_at as created_at',
                'u.id as user_id',
                'u.name as name',
                'questions.status as status',
                'categories.name as category',
            )
            ->join('categories_questions as cq', 'cq.question_id', '=', 'questions.id')
            ->join('categories', 'categories.id', '=', 'cq.category_id')
            ->join('users as u', 'u.id', '=', 'questions.user_id')
            ->selectRaw('count(q.question_id) as course_count')
            ->orderBy('questions.created_at', 'asc')
            ->groupBy(['categories.name','u.name', 'u.id', 'questions.status', 'questions.id', 'questions.description', 'questions.created_at'])
            ->where('categories.level', '=', Category::DEFAULD_PARENT_ID)
            ->paginate(20);
        return view('admin.question.question', compact('rows'));
    }

    public function edit($id){

        $row = Question::find($id);
        if(!$row){
            session()->flash('danger', __('question.message-course-not-found'));
            return redirect()->route('admin.question');
        }
        $options = $row->options;
        $courseEntity = new Course();
        $categoryEntity = new Category();

        $courses = $courseEntity->all();
        $categories = DB::table('categories')
            ->where('level', '=',1)->get();

        $activeCourse = $courseEntity->getCourseByQuestionId($id);
        $activeCategory = $categoryEntity->getCategoryByQuestionId($id);
        $categoryParentId = 0;
        $subCategories = [];

        if(!empty($activeCategory)){
            $categoryId = $activeCategory[0];
            $category = $categoryEntity->find($categoryId);
            $categoryParentId = ($category->level == Category::DEFAULD_PARENT_ID) ? $category->id : $category->parent_id;
            if($category->level == Category::DEFAULD_PARENT_ID){
                $subCategories = $category->children()->get();
            }
        }


        return view('admin.question.form',
            compact( 'row' ,
                   'options',
                              'courses',
                              'activeCourse',
                              'categoryParentId',
                              'subCategories',
                              'activeCategory',
                              'categories')
        );
    }

    public function uploadImage(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,gif|max:512'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/uploads/' .  date('Y/m'), $filename);
            $url = url(Storage::url($path));

            return response()->json(['url' =>   $url, 'error' => '']);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'description' => ['required','string'],
                'answer' => ['required','min:1'],
                'option' => ['required','array','min:2'],
            ]);

            $categories = array_merge($request->subcategory,[$request->category]);
            try{
                DB::beginTransaction();
                $categoryEntity = new Category();

                if(empty($request->id)) {

                    $question = Question::create([
                        'description' => $request->description,
                        'user_id' => Auth::user()->id
                    ]);

                    foreach ($request->option as $id=>$row){
                        if(!empty($row['description'])){
                           $option =  Option::create([
                                'description' =>  $row['description'],
                                'point' => $request->answer == $id ? 1 : 0,
                                'question_id' => $question->id,
                            ]);
                        }
                    }
                    $questionEntity = new Question();
                    foreach ($request->course as $row){
                        $data = [
                            'question_id' => $question->id,
                            'course_id' => $row
                        ];
                        $questionEntity->insertCourseQuestion($data);
                    }
                    foreach ($categories as $row){
                        $data = [
                            'question_id' => $question->id,
                            'category_id' => $row
                        ];
                        $categoryEntity->insertCategoryQuestion($data);
                    }
                    session()->flash('success', __('question.message-add'));
                }else{
                    //Save question
                    $questionEntity = new Question();
                    $question = $questionEntity->find($request->id);
                    $question->description = $request->description;
                    $question->user_id = Auth::user()->id;
                    $question->save();

                    $questionEntity = new Question();

                    $questionEntity->clearCourseQuestion($question->id);

                    foreach ($request->course as $row){
                        $data = [
                            'question_id' => $question->id,
                            'course_id' => $row
                        ];
                        $questionEntity->insertCourseQuestion($data);
                    }
                    $categoryEntity->clearCategoryQuestion($question->id);

                    foreach ($categories as $row){
                        $data = [
                            'question_id' => $question->id,
                            'category_id' => $row
                        ];
                        $categoryEntity->insertCategoryQuestion($data);
                    }

                    foreach ($request->option as $id=>$row){
                        if(!empty($id)){
                            $option = Option::find($id);
                            $option->description = $row['description'];
                            $option->point  = $request->answer == $id ? 1 : 0;
                            $option->save();
                        }
                    }
                    session()->flash('success', __('question.message-update'));
                }
                DB::commit();
                return redirect()->route('admin.question');
            }catch (\Exception $exception){
                DB::rollBack();
                session()->flash('danger', $exception->getMessage());
                return redirect()->route('admin.question');
            }

        }
        $courseEntity = new Course();
        $courses = $courseEntity->all();
        $categories = DB::table('categories')
            ->where('level', '=',1)->get();
        $subCategories = [];

        return view('admin.question.form',
            compact(
                 'subCategories',
                'courses',
                'categories'
            )
        );

    }


    public function status($question_id){
        $validator = Validator::make(['question_id' => $question_id], [
            'question_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => __('question.message-question-not-found')], 400);
        }
        $question = Question::find($question_id);
        $response = ['status' => 'error'];
        if($question){
            $status = $question->status == 1 ? 0 : 1;
            $question->status = $status;
            $question->save();
            $response = [
                'message' => __('question.message-update'),
                'label' => $status ? __('question.label-enable') : __('question.label-disable'),
                'status' => 'ok'
            ];
        }
        return response()->json($response);
    }


    public function remove($id){
        $question = Question::find($id);
        $status = 'ok';
        if(!$question){
            $message = __('question.message-question-not-found');
            $status = 'error';
        }else{
            $question->delete();
            $message = __('question.message-delete-successs',['question' => $question->id]);
        }
        return response()->json([
            'message' => $message,
            'title' => __('category.label-deleted'),
            'status' => $status,
        ]);
    }

}
