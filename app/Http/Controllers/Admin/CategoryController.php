<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    public function index(){

        $rows = Category::leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select('categories.name as name',
                'parent.name as parent_name',
                'categories.id as id',
                'categories.level as level',
                'categories.created_at as created_at'
            )
            ->orderBy('categories.level', 'asc')
            ->orderBy('categories.parent_id', 'asc')
            ->orderBy('categories.name', 'asc')
            ->paginate(20);
        return view('admin.category.category', compact('rows'));
    }

    public function edit($id){

        $row = Category::find($id);
        if(!$row){
            session()->flash('danger', __('category.message-course-not-found'));
            return redirect()->route('admin.categoty');
        }

        $childrens = $row->children()->get();
        $parents = [];
        if(!empty($row->parent_id)){
            $parent = Category::find($row->parent_id);
            $parents = DB::table('categories')
                ->where('level', '=',$parent->level)->get();
        }
        return view('admin.category.form',
            compact( 'row' ,'childrens' ,'parents')
        );
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'name' => ['required','string','max:100', Rule::unique('courses')->ignore($request->id),],
            ]);
            try {
                if(empty($request->id)) {
                    $parent = Category::find($request->parent_id);
                    $category = Category::create([
                        'name' => $request->name,
                        'parent_id' => $request->parent_id,
                        'level' => $parent->level + 1,
                    ]);
                    if(!empty($request->subcategory)) {
                        foreach ($request->subcategory as $subcategory) {
                            if(!empty($subcategory)) {
                                $subcategory = Category::create([
                                    'name' => $subcategory,
                                    'parent_id' => $category->id,
                                    'level' => $category->level + 1,
                                ]);
                            }
                        }
                    }

                    session()->flash('success', __('category.message-add'));
                }else{
                    $category = Category::find($request->id);
                    foreach (['name','parent_id'] as $field) {
                        $category->$field = $request->$field;
                    }
                    $category->save();

                    if(!empty($request->subcategory)) {
                        foreach ($request->subcategory as $subcategory) {
                            if(!empty($subcategory)) {
                                $subcategory = Category::create([
                                    'name' => $subcategory,
                                    'parent_id' => $category->id,
                                    'level' => $category->level + 1,
                                ]);
                            }
                        }
                    }
                    session()->flash('success', __('category.message-update'));
                }
                return redirect()->route('admin.category');
            }catch (\Exception $exception){
                session()->flash('danger', $exception->getMessage());
            }
        }

        $parents = DB::table('categories')
            ->where('level', '=',Category::DEFAULD_PARENT_ID)->get();

        return view('admin.category.form',
            compact( 'parents')
        );
    }


    public function remove($id){
        $category = Category::find($id);
        $status = 'ok';
        if(!$category){
            $message = __('school.message-school-not-found');
            $status = 'error';
        }else{
            $children = $category->children()->get();
            if($children->count() <= 0){
                $category->delete();
                $message = __('category.message-delete-successs',['category' => $category->name]);
                $status = 'error';
            }else{
                $message = __('category.message-delete-warning',['category' => $category->name]);
            }
        }
        return response()->json([
            'message' => $message,
            'title' => __('category.label-deleted'),
            'status' => $status,
        ]);
    }

    public function showByCategory($category_id)
    {

        $validator = Validator::make(['category_id' => $category_id], [
            'category_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => __('category.message-course-not-found')], 400);
        }
        $categories = Category::where('parent_id', $category_id)
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($categories);
    }

}
