<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeptToCurricula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curricula', function (Blueprint $table) {
            $table->string('offered_by')->nullable;
            $table->string('offered_to')->nullable;
            // $table->foreign('offered_to')->references('dept_code')->on ('department');
            // $table->foreign('offered_by')->references('dept_code')->on ('department');
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
            Schema::dropIfExists('offered_by');
            Schema::dropIfExists('offered_to');
        });
    }
}
