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
        Schema::create('meeting_link', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('class')->nullable();
            $table->string('topic_id')->nullable();
            $table->string('subtopic_id')->nullable();
            $table->dateTime('from_meeting_time',6)->nullable();
            $table->string('class_room')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('to_meeting_time', 6)->nullable();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
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
        Schema::dropIfExists('meeting_link');
    }
};