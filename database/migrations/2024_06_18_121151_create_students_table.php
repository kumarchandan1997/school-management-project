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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('surname');
            $table->string('student_num');
            $table->date('birth_date');
            $table->string('address')->nullable();
            $table->string('parent_phone_number');
            $table->string('father_name')->nullable();
            $table->boolean('gender');
            $table->integer('classroom_id')->unsigned();
            $table->foreign('classroom_id')->references('id')->on('classrooms');
            $table->date('enrollment_date');
            $table->string('school');
            $table->string('email');
            $table->string('password');
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
        Schema::dropIfExists('students');
    }
};