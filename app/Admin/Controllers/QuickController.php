<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Quick;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class QuickController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Quick(), function (Grid $grid) {
            $grid->model()->orderBy('sort');
            $grid->column('text');
            $grid->column('img')->image('',30,30);
            $grid->column('sort')->orderable();

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
        return Show::make($id, new Quick(), function (Show $show) {
            $show->field('id');
            $show->field('text');
            $show->field('img');
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
        return Form::make(new Quick(), function (Form $form) {

            $form->text('text');
            $form->image('img')->uniqueName()->autoUpload();
            $form->hidden('sort');
            $form->saved(function (Form $form, $result) {
                Cache::forget('quick');
            });



        });
    }
}
