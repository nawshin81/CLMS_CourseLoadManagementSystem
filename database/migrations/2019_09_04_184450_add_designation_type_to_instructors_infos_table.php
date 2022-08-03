<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDesignationTypeToInstructorsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructors_infos', function (Blueprint $table) {
            //
            $table->string('designation_type')->nullable();
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
            //
             Schema::dropIfExists('instructors_infos');
        });
    }
}
