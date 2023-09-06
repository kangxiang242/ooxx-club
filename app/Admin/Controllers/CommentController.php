<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Form\CommentBatchDelete;
use App\Admin\Repositories\Comment;
use Dcat\Admin\Admin;
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
            $grid->model()->orderBy('id','desc')->setPerPage(50);
            $grid->column('image','圖片')->display(function($pictures){
                return explode(',',$pictures);
            })->image('', 50, 50);
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            //$grid->enableDialogCreate();
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new CommentBatchDelete());
            });

            Admin::style(<<<STYLE
.reset-btn{
    float:right;
    margin-left:20px;
}
STYLE
);
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
        Admin::style(<<<STYLE
.card {
        flex-direction: column-reverse;
}
.card .box-header{
    display:none;
}
STYLE
);
        return Form::make(new Comment(), function (Form $form) {
            $form->multipleImage('image','圖片')->autoUpload()->uniqueName()->saving(function ($paths){
                return implode(',', $paths);
            });

            $form->disableCreatingCheck();


            $form->saving(function (Form $form) {

                $images = explode(',',$form->image);
                $form->deleteInput('image');
                $comment_picture = array_chunk($images,1000);
                foreach($comment_picture as $image){
                    $insert = [];
                    foreach($image as $item){
                        $insert[] = [
                            'image'=>$item,
                        ];
                    }
                    \App\Models\Comment::insert($insert);
                }
                // 中断后续逻辑
                return $form->response()->success('操作成功');
            });



        });
    }
}
