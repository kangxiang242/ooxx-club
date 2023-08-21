<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledsIntoBirthplaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('birthplaces', function (Blueprint $table) {
            $table->string('price_range')->nullable();
            $table->tinyInteger('allow_type')->default(0);
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
            $table->dropColumn(['price_range','allow_type']);
        });
    }
}
