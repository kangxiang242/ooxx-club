<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Seo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;
class SeoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Seo(), function (Grid $grid) {

            $grid->column('path','URL');
            $grid->column('title');
            $grid->column('key_word');
            $grid->column('description');
            $grid->disableRowSelector();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
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
        return Show::make($id, new Seo(), function (Show $show) {
            $show->field('id');
            $show->field('path');
            $show->field('title');
            $show->field('key_word');
            $show->field('description');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Seo(), function (Form $form) {
            $form->text('path','URL路徑')->help('如：https://xxx.com/article 填入 /article 即可');
            $form->text('title');
            $form->text('key_word');
            $form->text('description');
            /*$form->radio('title_tail','TITLE是否自動添加尾部')->options([0=>'否',1=>'是'])->default(1)->help('尾部内容在網站設置修改');*/
            $form->saved(function(){
                Cache::forget(config('global.cache.seo'));
            });
            $form->disableViewButton();
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
