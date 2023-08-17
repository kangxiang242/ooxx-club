<?php

namespace App\Admin\Forms;



use App\Models\Category;
use Dcat\Admin\Form\NestedForm;

class Banner extends Config
{

    public $title = '首页轮博';

    public function form()
    {
        //$this->image('test_image','图片')->autoUpload()->uniqueName();
        $this->array('home_banners','轮博', function (NestedForm $table) {
            $table->image('image','图片')->url('upload/files')->autoUpload()->uniqueName();

            $table->text('alt','图片ALT');
            $table->text('href','跳转路径');
        });



    }

}
