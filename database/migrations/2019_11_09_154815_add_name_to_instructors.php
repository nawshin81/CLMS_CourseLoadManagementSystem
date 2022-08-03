<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToInstructors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructors_infos', function (Blueprint $table){
            $table->string('name');
            $table->integer('credit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructors_infos', function (Blueprint $table) {
            Schema::dropIfExists('name');
            Schema::dropIfExists('credit');
        });
    }
}
