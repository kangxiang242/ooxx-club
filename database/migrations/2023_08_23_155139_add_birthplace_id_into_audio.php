<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthplaceIdIntoAudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->unsignedBigInteger('birthplace_id')->after('id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->dropColumn('birthplace_id');
        });
    }
}
