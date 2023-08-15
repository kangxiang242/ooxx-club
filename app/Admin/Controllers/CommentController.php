<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Comment;
use App\Combine\Compose;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class CommentController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {



        return Grid::make(new Comment(), function (Grid $grid) {

            $grid->column('image','圖片')->display(function($pictures){
                return explode(',',$pictures);
            })->image('', 50, 50);
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
        return Show::make($id, new Comment(), function (Show $show) {
            $show->field('id');
            $show->field('image');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Comment(), function (Form $form) {
            $form->multipleImage('image','圖片')->autoUpload()->uniqueName()->saving(function ($paths){
                return implode(',', $paths);
            });
        });
    }
}
