<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teach', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instructor_id')->unsigned();
            $table->string('course_code');
            $table->decimal('course_credit',10,2);
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
        Schema::dropIfExists('teach');
    }
}
