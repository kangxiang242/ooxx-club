<?php

namespace App\Admin\Controllers;


use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use App\Http\Controllers\Controller;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Support\Arr;

class SiteGuideController extends Controller
{

    private $model;

    private $configs;

    private $form;

    protected $tabs = [
        [
            'text'=>'首页',
            'method'=>'home',
        ],

        [
            'text'=>'服务图库',
            'method'=>'serve',
        ],
    ];

    protected $default = 'home';



    public function __construct(\App\Models\Config $config, \Dcat\Admin\Widgets\Form $form)
    {

        $this->model = $config;
        $this->configs = $this->model->pluck('content','name')->toArray();

        $this->form = $form;
        $form->action(admin_url('site'));
        $form->disableResetButton();
    }

    public function index(Content $content){

        $content->row(function (Row $row) {
            $type = request('_t', $this->default);
            $tab = new Tab();

            foreach($this->tabs as $item){
                if($item['method'] == $type){
                    $this->$type();
                    $tab->add($item['text'], $this->form,true);
                }else{
                    $tab->addLink($item['text'], request()->fullUrlWithQuery(['_t' => $item['method']]));
                }
            }



            $row->column(12, $tab->withCard());
        });

        return $content
            ->header('单页管理');

    }

    public function home(){
        $this->form->textarea('config.index_v_text','首页视频文字')->default(Arr::get($this->configs,'index_v_text',''));

        $this->form->textarea('config.header_about','头部介绍')->default(Arr::get($this->configs,'header_about',''));

        $this->form->textarea('config.footer_about','页尾介绍')->rows(10)->default(Arr::get($this->configs,'footer_about',''));

        $this->form->weditor('config.about_content','关于我们')->default(Arr::get($this->configs,'about_content',''));

        $this->form->multipleImage2('config.slide_images','页尾跑马灯圖')->limit(200)->url('upload/files')->autoUpload()->uniqueName()->default(Arr::get($this->configs,'slide_images',''));


    }


    public function serve(){
        $this->form->multipleImage2('config.serve_images1','台湾图库')->limit(200)->url('upload/files')->autoUpload()->uniqueName()->default(Arr::get($this->configs,'serve_images1',''));
        $this->form->multipleImage2('config.serve_images2','全球图库')->limit(200)->url('upload/files')->autoUpload()->uniqueName()->default(Arr::get($this->configs,'serve_images2',''));
    }



}
