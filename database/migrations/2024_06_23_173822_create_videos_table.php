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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('course_title')->nullable();
            $table->string('subject_code')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Pending');
            $table->string('courses_type')->nullable();
            $table->string('topic_id')->nullable();
            $table->string('subtopic_id')->nullable();
            $table->string('video')->nullable();
            $table->string('diksh')->nullable();
            $table->string('games')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->boolean('share')->default(0);
            $table->string('app')->nullable();
            $table->string('test')->nullable();
            $table->string('classroom')->nullable();
            
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade')->nullOnDelete();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade')->nullOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade')->nullOnDelete();
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
        Schema::dropIfExists('videos');
    }
};