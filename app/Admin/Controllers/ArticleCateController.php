<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ArticleCate;
use App\Models\Picture;
use App\Services\ImageService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class ArticleCateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $picture = Picture::first();
        $images = explode(',',$picture->image);
        foreach ($images as $item){
            $img = public_path('uploads/'.$item);
            app(ImageService::class)->resize($img,20);
            dd($img);
        }

        return Grid::make(new ArticleCate(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('status','状态')->using([0 => '停用', 1 => '正常',])->label([
                0 => 'danger',
                1 => 'success',
            ]);
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                /*$actions->disableDelete();*/
            });
            $grid->disableRowSelector();
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
        return Show::make($id, new ArticleCate(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('created_at');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ArticleCate(), function (Form $form) {

            $form->text('name')->required();
            $form->text('sub_name','副标题');
            $form->text('uri','路径')->help('如填写：news, 前端url等於http://xxx.com/news，勿随意更改以免影响seo')->required();
            $form->radio('status','状态')->options(['1' => '上架', '0'=> '下架'])->default('1')->required();
            $form->number('sort','排序')->min(1)->default(1)->help('數值越大排序越前')->required();
            $form->textarea('desc','描述');
            $form->saved(function(){
                Cache::forget(config('global.cache.article_cate')); //删除缓存
            });
            $form->disableViewButton();
            $form->disableDeleteButton();
            $form->footer(function ($footer) {

                // 去掉`重置`按钮
                $footer->disableReset();

                // 去掉`查看`checkbox
                $footer->disableViewCheck();

                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();

                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();
            });
        });
    }
}
