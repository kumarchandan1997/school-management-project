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
        Schema::table('games', function (Blueprint $table) {
            $table->unsignedBigInteger('topic_id')->nullable()->after('classroom_id');
            $table->unsignedBigInteger('subtopic_id')->nullable()->after('topic_id');

            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('subtopic_id')->references('id')->on('subtopics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('topic_id');
            $table->dropColumn('subtopic_id');
        });
    }
};