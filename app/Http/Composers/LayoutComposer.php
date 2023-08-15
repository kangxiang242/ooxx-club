<?php


namespace App\Http\Composers;




use App\Repositories\ArticleCateRepository2;
use App\Repositories\BannerRepository;


use App\Repositories\ProductRepository2;
use App\Repositories\SeoRepository2;


use App\Services\ConfigService;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LayoutComposer
{
    private $view;

    private $uri;

    private $path;

    private $data = [];


    public function all(View $view){

        $this->view = $view;

        $this->path = request()->path();

        if(request()->route()){
            $this->uri = request()->route()->uri();

        }

        /*$this->seo();

        $this->getArticleCate();*/



        //$this->view->with('layout',$this->data);
    }

    /**
     * 獲取seo三大標簽
     */
    protected function seo(){

        $seo = app(SeoRepository2::class)->findPath('/'.trim($this->path,'/'));
        if(!$seo){
            $seo = app(SeoRepository2::class)->findPath('/'.trim($this->uri,'/'));
        }

        if($seo && $seo->title_tail == 1){
            $seo->title = $seo->title.ConfigService::get('seo_title_tail');
        }
        //$this->data['seo'] = $seo;

    }


    public function getArticleCate(){
        $this->data['global-article-cate'] = app(ArticleCateRepository2::class)->getAll();
    }





}
