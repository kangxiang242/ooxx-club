<?php

namespace App\Admin\Forms;



class Setting extends Config
{

    public $title = '基本配置';

    public function form()
    {

        $this->text('site_name','網站名稱');
        $this->image('site_logo','LOGO')->autoUpload()->uniqueName();
        $this->image('favicon','favicon')->autoUpload()->uniqueName();
        //$this->image('loading', 'loading')->autoUpload()->uniqueName();

        $this->textarea('loading_code','loading代码')->rows(10);
        $this->text('copyright','版版所有');




    }

}
