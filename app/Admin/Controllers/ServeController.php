<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Serve;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class ServeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Serve(), function (Grid $grid) {
            $grid->column('name');
            $grid->column('icon')->image('',20,20);
            $grid->column('price');
            $grid->column('created_at');
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();

            $grid->quickSearch(['name']);
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
        return Show::make($id, new Serve(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('icon');
            $show->field('price');
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
        return Form::make(new Serve(), function (Form $form) {

            $form->text('name');
            $form->image('icon')->autoUpload()->uniqueName();
            $form->text('price')->help('英文逗号隔开');
            $form->saved(function (Form $form, $result) {
                Cache::forget('serve');
            });

        });
    }
}
