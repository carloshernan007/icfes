<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\School;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Region;
use App\Models\City;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class UserController extends Controller
{

    public function index()
    {
        $users = User::leftJoin('registers', 'users.id', '=', 'registers.user_id')
            ->leftJoin('cities', 'registers.city_id', '=', 'cities.id')
            ->leftJoin('schools', 'registers.school_id', '=', 'schools.id')
            ->select('users.*',
                     'registers.*',
                     'cities.name as city_name',
                     'schools.name as school_name',
                     'users.id as user_id',
                     'users.role as role',
                     'users.created_at as created'
            )
            ->orderBy('registers.fullname', 'desc')
        ->paginate(20);


        return view('admin.user', compact('users'));
    }

    public function edit($id)
    {
        $regionId = 0;
        $cities = $courses = [];
        $user = User::find($id);
        $register = User::find($id)->register;
        $roles = User::ROLES;
        $regions = Region::all();
        $schools = School::all();
        $courseEntity = new Course();
        $courseActive = $courseEntity->getCursesByUserId($user->id);
        if($register) {
            $city = new City();
            $cityEntity = $city->find($register->city_id);
            $regionId = $cityEntity->region_id;
            $cities = $city->getCitiesByRegionId($regionId);
            $courses = $courseEntity->getCursesBySchool($register->school_id);
        }
        return view('admin.form',
            compact('user',
                  'register',
                             'roles',
                             'cities',
                             'regions',
                             'courseActive',
                             'regionId',
                             'schools',
                             'courses'
            )
        );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required','string','max:100', Rule::unique('users')->ignore($request->user_id),],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($request->user_id)],
            'fullname' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'string', 'max:1'],
            'address' => ['required', 'string', 'max:100'],
            'school_id' => ['required', 'numeric'],
            'region_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
        ]);

        try {
            DB::beginTransaction();
            if(empty($request->user_id)) {
                $user = new User();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role
                ]);
            }else{
                $user = User::find($request->user_id);
                $user->update($validatedData);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            if(!empty($request->password)){
                $user->password = Hash::make($request->password);
            }
            $user->save();
            if(empty($request->register_id)) {
                $regiser = Register::create([
                    'user_id' => $user->id,
                    'fullname' => $request->fullname,
                    'gender' => $request->gender,
                    'school_id' => $request->school_id,
                    'city_id' => $request->city_id,
                    'address' => $request->address,
                    'ip' => $request->ip()
                ]);
            }else{
                $register = Register::find($request->register_id);
                foreach (['fullname', 'gender', 'school_id', 'city_id', 'address'] as $field) {
                   $register->$field = $request->$field;
                }
                $register->save();
            }

            if(!empty($request->courses)) {
                DB::table('courses_users')->where('user_id', '=', $user->id)->delete();
                foreach ($request->courses as $course) {
                    Course::insertCourse([
                        'user_id' => $user->id,
                        'course_id' => $course
                    ]);
                }
            }
            DB::commit();

        }catch (\Exception $e){
            Log::info($e->getMessage());
            DB::rollBack();
            return redirect(route('admin.user.edit',$request->user_id));
        }
        return redirect()->route('admin.user', ['absolute' => false])->with('success', __('users.message-success'));
    }

    public function create()
    {
        $roles = User::ROLES;
        $regions = Region::all();
        $schools = School::all();
        return view('admin.form',
            compact(
                'roles',
                'regions',
                'schools',
            )
        );
    }
}
