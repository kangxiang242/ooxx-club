<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('birthplace_id')->comment('茶籍');
            $table->string('name')->comment('名稱');
            $table->string('cover')->nullable()->comment('封面圖');
            $table->integer('age')->default(0)->comment('年齡');
            $table->integer('height')->default(0)->comment('身高');
            $table->integer('weight')->default(0)->comment('體重');
            $table->char('cup',10)->comment('罩杯');
            $table->unsignedBigInteger('area_city')->nullable()->comment('市');
            $table->unsignedBigInteger('area_county')->nullable()->comment('縣');

            $table->decimal('price_start',8,0)->default(0)->comment('最低價格');
            $table->decimal('price_end',8,0)->default(0)->comment('最高價格');

            $table->longText('picture')->nullable()->comment('圖片');
            $table->longText('comment_picture')->nullable()->comment('客評圖片');
            $table->string('video')->nullable()->comment('視頻');
            $table->string('audio')->nullable()->comment('音頻');
            $table->integer('audio_time')->default(0)->comment('音频时长');
            $table->integer('sort')->default(0)->comment('排序');

            $table->tinyInteger('status')->default(1)->comment('狀態');

            $table->tinyInteger('sham')->default(0)->comment('虚假');
            $table->tinyInteger('outgoing')->default(1)->comment('外送');
            $table->tinyInteger('fixation')->default(1)->comment('定点');

            $table->tinyInteger('type')->default(1)->comment('1=外送 2=定点');
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
        Schema::dropIfExists('products');
    }
}
