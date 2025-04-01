<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Inquiry;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class InquiryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Inquiry(), function (Grid $grid) {
            $grid->model()->orderBy('created_at','desc');
            $grid->column('type');
            $grid->column('referer');
            $grid->column('position');
            $grid->column('device','装置');
            $grid->column('ip');
            $grid->column('created_at');
            $grid->disableActions();
            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('type')->width(4);
                $filter->like('referer')->width(4);
                $filter->equal('position')->width(4);
                $filter->equal('IP')->width(4);
                $filter->equal('device','装置')->select(['pc'=>'pc','mobile'=>'mobile'])->width(4);
                $filter->panel();
                $filter->expand();
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
        return Show::make($id, new Inquiry(), function (Show $show) {
            $show->field('id');
            $show->field('type');
            $show->field('referer');
            $show->field('position');
            $show->field('user_agent');
            $show->field('ip');
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
        return Form::make(new Inquiry(), function (Form $form) {

            $form->text('type');
            $form->text('referer');
            $form->text('position');
            $form->text('user_agent');
            $form->text('ip');

        });
    }
}
