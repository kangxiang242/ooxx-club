<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Dcat\Admin\Widgets\Card;

class SiteController extends Controller
{

    /**
     * 配置
     *
     * @param Content $form
     * @return Content
     */
    public function index($form){
        $content = new Content;
        $form = str_replace('-', '', ucwords($form, '-'));

        try {
            $form = app("App\Admin\Forms\\".$form);
        }catch (\Illuminate\Contracts\Container\BindingResolutionException $exception){
            abort(404);
        }
        return $content->title($form->title)->body(new Card($form));

    }


}
