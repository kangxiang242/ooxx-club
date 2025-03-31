<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiaisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liaisons', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->nullable();
            $table->string('line_id')->nullable();
            $table->string('line_url')->nullable();
            $table->string('line_qrcode')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liaisons');
    }
}
