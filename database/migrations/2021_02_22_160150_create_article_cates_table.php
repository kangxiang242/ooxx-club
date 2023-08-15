<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_cates', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->comment('文章分類');
            $table->integer('sort')->default(1)->comment('排序，从小到大');
            $table->tinyInteger('status')->default(1)->comment('1正常 0关闭');
            $table->string('uri')->nullable()->comment('路径');
            $table->longText('desc')->nullable()->comment('描述');
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
        Schema::dropIfExists('article_cates');
    }
}
