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
        Schema::table('meeting_link', function (Blueprint $table) {
            // Rename the column 'class_time' to 'from_meeting_time'
            $table->renameColumn('class_time', 'from_meeting_time');

            // Add the new column 'to_meeting_time'
            $table->dateTime('to_meeting_time', 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meeting_link', function (Blueprint $table) {
             // Rename the column 'from_meeting_time' back to 'class_time'
             $table->renameColumn('from_meeting_time', 'class_time');

             // Drop the column 'to_meeting_time'
             $table->dropColumn('to_meeting_time');
        });
    }
};