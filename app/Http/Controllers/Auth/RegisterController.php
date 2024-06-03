<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Region;
use App\Models\School;
use App\Models\User;
use App\Models\Register;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        showRegistrationForm as laravelShowRegistrationForm;
        register as laravelRegister;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $schools = School::all();
        $regions = Region::orderBy('name','asc')->get();
        return view('auth.register',['schools' => $schools,'regions' => $regions]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
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
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255','unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'fullname' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'string', 'max:1'],
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
                'role' => User::STUDENT
            ]);

            $regiser = Register::create([
                'user_id' => $user->id,
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'school_id' => $request->school_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'ip' => $request->ip()
            ]);

            Course::insertCourse([
                'user_id' => $user->id,
                'course_id' => $request->course_id
            ]);

            DB::commit();
        /*}catch (ValidationException $e) {
            Log::info($e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
*/
        }catch (\Exception $e){
            Log::info($e->getMessage());
            DB::rollBack();
            return redirect(route('register', absolute: false));
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
