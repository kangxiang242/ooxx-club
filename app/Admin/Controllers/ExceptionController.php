<?php

namespace App\Admin\Controllers;

use App\Models\Exception;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ExceptionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Exception(), function (Grid $grid) {
            $grid->model()->orderBy('created_at','desc');
            $grid->column('method');
            $grid->column('uri');
            $grid->column('referer','引用页');
            $grid->column('ip');
            $grid->column('ip_country');

            $grid->column('message');


            $grid->column('user_agent')->limit(50);
            $grid->column('parameters');
            $grid->column('created_at');

            $grid->disableCreateButton();
            $grid->disableActions();
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
        return Show::make($id, new Exception(), function (Show $show) {
            $show->field('id');
            $show->field('ip');
            $show->field('ip_country');
            $show->field('status_code');
            $show->field('message');
            $show->field('uri');
            $show->field('method');
            $show->field('user_agent');
            $show->field('parameters');
            $show->field('headers');
            $show->field('trace');
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
        return Form::make(new Exception(), function (Form $form) {
            $form->display('id');
            $form->text('ip');
            $form->text('ip_country');
            $form->text('status_code');
            $form->text('message');
            $form->text('uri');
            $form->text('method');
            $form->text('user_agent');
            $form->text('parameters');
            $form->text('headers');
            $form->text('trace');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
