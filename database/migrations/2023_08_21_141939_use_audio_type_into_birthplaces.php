<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UseAudioTypeIntoBirthplaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('birthplaces', function (Blueprint $table) {
            $table->tinyInteger('use_audio_type')->default(0);
            $table->tinyInteger('western')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('birthplaces', function (Blueprint $table) {
            $table->dropColumn('use_audio_type');
            $table->dropColumn('western');
        });
    }
}
