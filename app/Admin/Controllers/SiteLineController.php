<?php

namespace App\Admin\Controllers;


use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use App\Http\Controllers\Controller;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Support\Arr;

class SiteLineController extends Controller
{

    private $model;

    private $configs;

    private $form;

    protected $tabs = [
        [
            'text'=>'Line客服',
            'method'=>'line',
        ],

    ];

    protected $default = 'line';



    public function __construct(\App\Models\Config $config, \Dcat\Admin\Widgets\Form $form)
    {

        $this->model = $config;
        $this->configs = $this->model->pluck('content','name')->toArray();

        $this->form = $form;
        $form->action(admin_url('site'));
        $form->disableResetButton();
    }

    public function index(Content $content){
        $content->row(function (Row $row){

            //$tab = new Tab();
            $this->line();
            $row->column(12,Card::make($this->form));
        });

        return $content->header('客服配置');
    }

    public function line(){
        Admin::style(<<<STYLE
.help-block{
transform: translateY(-24px);
}

STYLE
);
        $this->form->text('config.line_name', '客服名稱')->default(Arr::get($this->configs,'line_name',''));
        $this->form->text('config.line_id', 'LINE ID')->default(Arr::get($this->configs,'line_id',''));
        $this->form->text('config.line_url', 'LINE鏈接')->default(Arr::get($this->configs,'line_url',''));
        $this->form->multipleImage('config.line_qrcode', 'LINE二維碼')->url('upload/files')->autoUpload()->sortable()->default(Arr::get($this->configs,'line_qrcode',''))->help('只生效第一張二維碼，其餘二維碼作為備用');
        $this->form->text('config.service_phone', '聯絡電話')->default(Arr::get($this->configs,'service_phone',''));
        $this->form->text('config.service_email', '電子郵箱')->default(Arr::get($this->configs,'service_email',''));
    }


}
