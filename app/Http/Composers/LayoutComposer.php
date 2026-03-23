<?php


namespace App\Http\Composers;

use App\Repositories\AreaRepository;
use App\Repositories\SeoRepository2;
use App\Services\ConfigService;

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
        $this->seo();


        $this->view->with('layout',$this->data);

        $areas = app(AreaRepository::class)->all();
        $this->view->with('areas',$areas);
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
        $this->data['seo'] = $seo;

    }







}
