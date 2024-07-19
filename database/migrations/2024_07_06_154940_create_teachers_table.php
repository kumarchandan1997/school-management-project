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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('teacher_num')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->text('photo_path')->nullable();
            $table->string('address')->nullable();
            $table->boolean('gender')->nullable();
            
            $table->integer('school_id')->unsigned()->nullable();
            $table->foreign('school_id')->references('id')->on('users')->nullOnDelete();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('teachers');
    }
};