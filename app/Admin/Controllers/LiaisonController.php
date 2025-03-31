<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Liaison;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class LiaisonController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Liaison(), function (Grid $grid) {

            $grid->column('nickname');
            $grid->column('line_id');
            $grid->column('line_url');
            $grid->column('line_qrcode')->image(null,50,50);
            $grid->column('phone');
            $grid->column('status')->switch();
            $grid->column('created_at');

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
        return Show::make($id, new Liaison(), function (Show $show) {
            $show->field('id');
            $show->field('nickname');
            $show->field('line_id');
            $show->field('line_url');
            $show->field('line_qrcode');
            $show->field('phone');
            $show->field('status');
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
        return Form::make(new Liaison(), function (Form $form) {
            $form->text('nickname');
            $form->text('line_id');
            $form->text('line_url');
            $form->image('line_qrcode')->autoUpload()->uniqueName();
            /*$form->text('phone','拨打格式电话');
            $form->text('show_phone','前端展示电话');*/
            $form->switch('status')->default(1);
            $form->saved(function (Form $form, $result) {
                Cache::forget('liaison');
            });


        });
    }
}
