<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDupTeachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dup_teach', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instructor_id')->unsigned();
            $table->string('course_code');
            $table->integer('course_credit');
            $table->integer('course_taken');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dup_teach');
    }
}
