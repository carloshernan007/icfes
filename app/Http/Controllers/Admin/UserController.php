<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


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
                     'users.role as role'
            )
            ->orderBy('registers.fullname', 'desc')
        ->paginate(20);


        return view('admin.user', compact('users'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $register = User::find($id)->register;
        $roles = User::ROLES;
        return view('admin.form', compact('user','register','roles'));
    }
}