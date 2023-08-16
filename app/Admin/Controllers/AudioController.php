<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Audio;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AudioController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Audio(), function (Grid $grid) {
            $grid->column('audio')->link(function (){
                return asset_upload($this->audio);
            });
            $grid->column('duration');
            $grid->column('status')->switch();
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
        return Show::make($id, new Audio(), function (Show $show) {
            $show->field('id');
            $show->field('audio');
            $show->field('duration');
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
        return Form::make(new Audio(), function (Form $form) {

            $form->file('audio')->autoUpload()->uniqueName()->retainable()->accept('mp3')->chunkSize(256);
            $form->number('duration')->default(15)->help('單位/秒');
            $form->hidden('status')->default(1);

        });
    }
}
