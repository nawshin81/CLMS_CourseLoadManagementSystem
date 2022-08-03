<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDeptToCurricula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curricula', function (Blueprint $table) {
             $table->foreign('offered_to')->references('dept_code')->on ('department');
     $table->foreign('offered_by')->references('dept_code')->on ('department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curricula', function (Blueprint $table) {
            
        });
    }
}
