<?php

namespace App\Admin\Forms;




use Dcat\Admin\Admin;

class Comment extends Config
{

    public $title = '客評截圖';

    public function form()
    {
        Admin::style(<<<STYLE
.form-horizontal{
    display: flex;
    flex-direction: column-reverse;
}
.card .box-footer{
    border-bottom: 1px solid #f4f4f4;
    border-top:none;
}
.card button[type="reset"]{
display:none;
}
.card button[type="submit"]{
    height: 40px;
    width: 100px;
}


STYLE
);
        $this->multipleImage('comment_picture','圖片')->limit(1000)->move('comment')->autoUpload()->uniqueName()->saving(function ($paths){
            return implode(',', $paths);
        });
    }

}
