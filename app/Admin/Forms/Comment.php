<?php

namespace App\Admin\Forms;




class Comment extends Config
{

    public $title = '客評截圖';

    public function form()
    {
        $this->multipleImage('comment_picture','圖片')->limit(500)->autoUpload()->sortable()->uniqueName()->thumbnail('small',10,17.92)->saving(function ($paths){
            return implode(',', $paths);
        });
    }

}
