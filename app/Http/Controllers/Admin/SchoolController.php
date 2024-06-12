<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

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
}
