<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class SchoolController extends Controller
{
    public function index(){

        $rows = School::leftJoin('users', 'schools.user_id', '=', 'users.id')
            ->leftJoin('cities', 'schools.city_id', '=', 'cities.id')
            ->select('users.*',
                'cities.name as city_name',
                'schools.created_at as created',
                'schools.name as school_name',
                'schools.description as school_description',
                'schools.address as school_address',
                'schools.id as school_id'
            )
            ->orderBy('schools.name', 'desc')
            ->paginate(20);
        return view('admin.school.school', compact('rows'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'name' => ['required','string','max:100', Rule::unique('schools')->ignore($request->id),],
                'description' => ['required', 'string', 'max:10000'],
                'address' => ['required', 'string', 'max:150'],
                'city_id' => ['required', 'numeric'],
            ]);

            try {
                if(empty($request->id)) {
                    $school = School::create([
                        'name' => $request->name,
                        'address' => $request->address,
                        'city_id' => $request->city_id,
                        'user_id' => Auth::id(),
                        'description' => $request->description
                    ]);
                   session()->flash('success', __('school.message-add'));
                }else{
                    $school = School::find($request->id);
                    foreach (['name', 'address', 'city_id', 'description'] as $field) {
                        $school->$field = $request->$field;
                    }
                    $school->user_id = Auth::id();
                    $school->save();
                    session()->flash('success', __('school.message-update'));
                }


                return redirect()->route('admin.school');
            }catch (\Exception $exception){
                session()->flash('danger', $exception->getMessage());
            }
        }

        $regions = Region::all();
        return view('admin.school.form',
            compact('regions'
            )
        );
    }

    public function edit($id){

        $school = School::find($id);
        if(!$school){
            session()->flash('danger', __('school.message-school-not-found'));
            return redirect()->route('admin.school');
        }

        $city = new City();
        $cityEntity = $city->find($school->city_id);
        $regionId = $cityEntity->region_id;
        $cities = $city->getCitiesByRegionId($regionId);


        $regions = Region::all();
        return view('admin.school.form',
            compact('regions','school','regionId','cities'
            )
        );
    }

    public function remove($id){
        $school = School::find($id);
        $status = 'ok';
        if(!$school){
            $message = __('school.message-school-not-found');
            $status = 'error';
        }else{
            if(!$school->hasRelatedRegisters()){
                $school->delete();
                $message = __('school.message-delete',['instituto' => $school->name]);
            }else{
                $message = __('school.message-delete-warning',['instituto' => $school->name]);
            }
        }
        return response()->json([
            'message' => $message,
            'title' => __('school.label-deleted'),
            'status' => $status
        ]);
    }
}
