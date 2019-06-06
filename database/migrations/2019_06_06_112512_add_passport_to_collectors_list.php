<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassportToCollectorsList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collectors_list', function (Blueprint $table) {
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->string('passport_issued_by')->nullable();
            $table->string('passport_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collectors_list', function (Blueprint $table) {
            //
        });
    }
}
