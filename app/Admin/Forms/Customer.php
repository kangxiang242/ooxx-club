<?php

namespace App\Admin\Forms;



class Customer extends Config
{

    public $title = '客服配置';

    public function form()
    {

        $this->text('line_name', '客服名稱');
        $this->text('customer_phone', '客服電話');
        $this->text('line_id', 'LINE ID');
        $this->text('line_url', 'LINE鏈接');
        $this->multipleImage('line_qrcode', 'LINE二維碼')->autoUpload()->sortable()->uniqueName()->saving(function ($paths){
            return implode(',',$paths);
        })->help('只生效第一張二維碼，其餘二維碼作為備用');
    }

}
