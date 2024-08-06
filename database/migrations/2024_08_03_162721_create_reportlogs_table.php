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
        Schema::create('reportlogs', function (Blueprint $table) {
            $table->id();
            $table->string('video_id');
            $table->string('content_name')->nullable();
            $table->string('teacher_id')->nullable();
            $table->string('classroom_id')->nullable();
            $table->string('subject_code')->nullable();
            $table->string('content')->nullable();
            $table->string('content_type')->nullable();
            $table->string('content_table_name')->nullable();
            $table->string('open_time')->nullable();
            $table->string('close_time')->nullable();
            $table->string('interval')->nullable();
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
        Schema::dropIfExists('reportlogs');
    }
};