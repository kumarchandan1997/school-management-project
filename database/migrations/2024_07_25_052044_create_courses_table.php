<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_title')->nullable();
            $table->string('subject_code')->nullable();
            $table->text('description')->nullable();
            $table->string('courses_type')->nullable();
            $table->string('url')->nullable();
            $table->string('pdf_video')->nullable();
            $table->string('teacher_id')->nullable();
            // $table->foreign('teacher_id')->references('id')->on('teachers')->nullOnDelete();
            $table->string('classroom_id')->nullable();
            // $table->foreign('classroom_id')->references('id')->on('classrooms')->nullOnDelete();

            $table->string('school_id')->nullable();
            // $table->foreign('school_id')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};