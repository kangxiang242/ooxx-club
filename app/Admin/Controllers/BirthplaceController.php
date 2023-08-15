<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Birthplace;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class BirthplaceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {


        return Grid::make(new Birthplace(), function (Grid $grid) {
            $grid->model()->orderBy('sort');
            $grid->column('name');
            $grid->column('icon')->image('',30,30);
            $grid->column('sort')->orderable();
            /*$grid->column('weight','權重');*/
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
        return Show::make($id, new Birthplace(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('icon');
            $show->field('sort');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Birthplace(), function (Form $form) {

            $form->text('name');
            $form->image('icon')->uniqueName()->autoUpload();
            $form->hidden('sort');
            //$form->number('weight','權重')->min(0)->max(100)->default(1);
            $form->saved(function (Form $form, $result) {
                Cache::forget('birthplace');
            });
        });
    }
}
