<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Anchor;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AnchorController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Anchor(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('url','URL')->display(function($url){
                return "<a target='_blank' href='$url'>$url</a>";
            });
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {

                $filter->like('key_word','關鍵詞');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
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
        return Show::make($id, new Anchor(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('url');
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
        return Form::make(new Anchor(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('url');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
