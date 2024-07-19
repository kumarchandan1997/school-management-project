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
        Schema::create('notification_tables', function (Blueprint $table) {
            $table->id();
            $table->string('school_id')->nullable();
            $table->string('student_id')->nullable();
            $table->string('teacher_id')->nullable();
            $table->string('notification_type')->nullable();
            $table->text('description')->nullable();
            $table->string('notification_url')->nullable();
            $table->timestamp('seen_at')->nullable();
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
        Schema::dropIfExists('notification_tables');
    }
};