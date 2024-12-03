<?php

namespace App\Admin\Controllers;


use App\Admin\Forms\BatchUploadVideoForm;
use App\Admin\Repositories\Video;
use App\Models\Birthplace;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Modal;
class VideoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Video::with('birthplace'), function (Grid $grid) {
            $grid->column('birthplace.name','茶籍')->display(function ($val){
                return $val ?? "未分類";
            });
            $grid->column('video')->link(function (){
                return asset_upload($this->video);
            });
            $grid->column('cover')->image('',50,50);
            $grid->column('status')->switch();
            $grid->column('created_at');
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();





            $modal = Modal::make()
                ->lg()
                ->title('批量导入')
                ->body(BatchUploadVideoForm::make())
                ->button('<div class="pull-right" style="margin-left: 20px"><button class="btn btn-primary">批量导入</button></div>');

            $grid->tools($modal);
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->selectOne('birthplace_id', '茶籍', Birthplace::pluck('name','id'));
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
        return Show::make($id, new Video(), function (Show $show) {
            $show->field('id');
            $show->field('video');
            $show->field('cover');
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
        return Form::make(new Video(), function (Form $form) {
            $form->select('birthplace_id','茶籍')->options(Birthplace::pluck('name','id'));
            $form->file('video')->move('video')->autoUpload()->uniqueName()->retainable()->accept('mp4')->chunked();
            $form->image('cover')->autoUpload()->uniqueName()->retainable();
            $form->hidden('status')->default(1);
        });
    }
}
