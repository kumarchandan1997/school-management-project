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
        Schema::create('liveclassshares', function (Blueprint $table) {
            $table->id();
            $table->string('students_ids');
            $table->unsignedBigInteger('teacher_id');
            $table->string('topic')->nullable();
            $table->string('sub_topic')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('done');
            $table->string('meeting_link')->nullable();
            $table->dateTime('meeting_time')->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liveclassshares');
    }
};