<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSwitchesToCollectorsList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collectors_list', function (Blueprint $table) {
            $table->boolean('briefing_passed')->default(false);
            $table->boolean('contract_signed')->default(false);
            $table->boolean('notary_passed')->default(false);
            $table->boolean('training_passed')->default(false);
            $table->boolean('telegram_attached')->default(false);
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
