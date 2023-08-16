<?php

namespace App\Admin\Forms;



class Searcher extends Config
{

    public $title = '搜索引擎';

    public function form()
    {
        $this->tab('Search Console', function () {
            $this->textarea('robots','robots')->rows(10);
            $this->multipleFile('google_verify_file', '验证文件')->autoUpload()->move('google-verify-file');
            $this->textarea('google_ga', 'GA代碼')->rows(10);
            $this->radio('disable_googlebot','谷歌蜘蛛')->options(['0'=> '正常訪問','1' => '禁止訪問',])->default(0);
        })->tab('首页独立版',function (){
            $this->textarea('googlebot_index_page','谷歌首页内容')->rows(20);
        });



    }

}
