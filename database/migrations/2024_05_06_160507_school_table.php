<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 150);
            $table->string('gender', 1)->nullable();;
            $table->string('address')->nullable();
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('courses_schools', function (Blueprint $table) {
            $table->bigInteger('school_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::create('courses_users', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('course_id')->references('id')->on('courses');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->integer('level')->default(2);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('categories');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->integer('point')->comment('[Points for evaluation 5 to 1]');
            $table->mediumText('description');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('option_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('option_id')->references('id')->on('options');
            $table->integer('point')->comment('[Points for evaluation 5 to 1]');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('categories_questions', function (Blueprint $table) {
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('courses_questions', function (Blueprint $table) {
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('course_id')->references('id')->on('courses');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
        Schema::dropIfExists('registers');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('courses_schools');
        Schema::dropIfExists('courses_users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('options');

    }
};
