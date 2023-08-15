<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Faq;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class FaqController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Faq(), function (Grid $grid) {
            $grid->model()->orderBy('sort');
            $grid->column('title');
            $grid->column('content')->limit(60);
            $grid->column('status')->switch();
            $grid->column('sort')->orderable();
            $grid->column('created_at');

            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();
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
        return Show::make($id, new Faq(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('content');
            $show->field('status');
            $show->field('sort');
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
        return Form::make(new Faq(), function (Form $form) {

            $form->text('title');
            $form->textarea('content');
            $form->switch('status');
            $form->hidden('sort');
            $form->saved(function (Form $form, $result) {
                Cache::forget('faq');
            });
        });
    }
}
