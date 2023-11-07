<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Topic;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TopicController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Topic(), function (Grid $grid) {

            $grid->column('title');
            $grid->column('status')->switch();
            $grid->column('quick');
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
        return Show::make($id, new Topic(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('content');
            $show->field('status');
            $show->field('quick');
            $show->field('seo_title');
            $show->field('seo_keyword');
            $show->field('seo_description');
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
        return Form::make(new Topic(), function (Form $form) {

            $form->text('title');
            $form->weditor('content');
            $form->hidden('status')->default(1);
            $form->text('quick');
            $form->text('seo_title');
            $form->text('seo_keyword');
            $form->text('seo_description');

        });
    }
}
