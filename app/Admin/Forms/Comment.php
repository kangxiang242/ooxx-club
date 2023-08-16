<?php

namespace App\Admin\Forms;




class Comment extends Config
{

    public $title = '客評截圖';

    public function form()
    {
        $this->multipleImage('comment_picture','圖片')->limit(1000)->move('comment')->autoUpload()->uniqueName()->saving(function ($paths){
            return implode(',', $paths);
        });
    }

}
