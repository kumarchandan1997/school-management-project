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
        Schema::create('educationalgameshares', function (Blueprint $table) {
            $table->id();
            $table->text('students_ids')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->unsignedBigInteger('sub_topic_id')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('done');
            $table->string('game_title')->nullable();
            $table->text('game_link')->nullable();
            $table->time('game_time')->nullable();
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
        Schema::dropIfExists('educationalgameshares');
    }
};