<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Add Administrator
        $administrator = new User([
            'name' => 'Carlos Hernan Aguilar',
            'email' => 'carlosa@example.com',
            'password' => bcrypt('admin'),
        ]);
        $administrator->assignRole('admin');
        $administrator->save();

        //Add Teacher
        $teacher = new User([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => bcrypt('teacher'),
        ]);
        $teacher->assignRole('teacher');
        $teacher->save();

        //Add Teacher
        $student = new User([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => bcrypt('student'),
        ]);
        $student->assignRole('student');
        $student->save();




    }
}
