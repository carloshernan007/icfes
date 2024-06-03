<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\School;
use App\Models\Region;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{




    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $schools = School::all();
        $regions = Region::orderBy('name','asc')->get();


        return view('auth.register',['schools' => $schools,'regions' => $regions]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store (Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255','unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'fullname' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'numeric', 'max:1'],
            'address' => ['required', 'string', 'max:100'],
            'school_id' => ['required', 'numeric'],
            'region_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'course_id' => ['required', 'numeric'],
        ]);

        try {
            DB::beginTransaction();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $regiser = Register::create([
                    'user_id' => $user->id,
                    'fullname' => $request->fullname,
                    'gender'  => $request->gender,
                    'school_id' => $request->shcool_id,
                    'city_id' => $request->city_id,
                    'address' => $request->address,
                ]);

                Course::insertCourse([
                    'user_id' => $user->id,
                    'course_id' => $request->course_id
                ]);

            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect(route('register2', absolute: false));
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
