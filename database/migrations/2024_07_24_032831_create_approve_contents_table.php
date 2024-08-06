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
        Schema::create('approve_contents', function (Blueprint $table) {
            $table->id();
            $table->string('classroom_id')->nullable();
            $table->string('subject_code')->nullable();
            $table->string('teacher_id')->nullable();
            $table->string('schoole_id')->nullable();
            $table->string('content')->nullable();
            $table->string('status')->default('Pending');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('approve_contents');
    }
};