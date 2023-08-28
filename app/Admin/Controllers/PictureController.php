<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Picture;
use App\Models\Birthplace;
use App\Services\ImageService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class PictureController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        if(!request()->has('_selector')){
            $url = admin_url('picture?_selector[birthplace_id]=1');
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$url);
            exit;
        }
        $_selector = request()->get('_selector');
        $birthplace_id = array_get($_selector,'birthplace_id',1);
        Cookie::queue('selected_birthplace_id',array_get($_selector,'birthplace_id',1));
        return Grid::make(new Picture(), function (Grid $grid) use ($birthplace_id) {
            $grid->model()->where('birthplace_id',$birthplace_id);
            $grid->column('image')->display(function($pictures){
                return explode(',',$pictures);
            })->image('', 50, 50);
            $grid->column('cup')->select(['C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G+'])->width(150);
            $grid->column('price_tag','价格标签')->select(['0'=>'无','1'=>'低','2'=>'中','3'=>'高','4'=>'超高'])->width(150);
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->selectOne('birthplace_id', '茶籍', Birthplace::pluck('name','id'));
            });

        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Picture(), function (Show $show) {
            $show->field('id');
            $show->field('image');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Picture(), function (Form $form) {
            if($form->isCreating()){
                $form->hidden('birthplace_id')->value(Cookie::get('selected_birthplace_id'));
            }

            $form->multipleImage('image')->autoUpload()->uniqueName()->retainable()->saving(function ($paths){
                return implode(',', $paths);
            });

            $form->radio('cup')->options(['C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G+']);

            $form->hidden('price_tag')->default(0);

            $form->saved(function (Form $form, $result) {
                $images = explode(',',$form->image);
                $imageService = app(ImageService::class);
                foreach($images as $item){
                    $path = public_path('uploads/'.ltrim($item,'/'));
                    if(file_exists($path)){
                        $imageService->resize($path,40);
                    }
                }
            });

        });
    }
}
