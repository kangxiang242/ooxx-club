<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchUploadVideo;
use App\Admin\Forms\BatchUploadVideoForm;
use App\Admin\Repositories\Video;
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
        return Grid::make(new Video(), function (Grid $grid) {

            $grid->column('video')->link(function (){
                return asset_upload($this->video);
            });
            $grid->column('cover')->image('',50,50);
            $grid->column('status')->switch();
            $grid->column('created_at');
            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();
            /*$modal = Modal::make()
                ->lg()
                ->title('标题')
                ->body(BatchUploadVideoForm::make())
                ->button('<div class="pull-right" style="margin-left: 20px"><button class="btn btn-primary">批量上传</button></div>');

            $grid->tools($modal);*/

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

            $form->file('video')->autoUpload()->uniqueName()->retainable()->accept('mp4')->chunked();
            $form->image('cover')->autoUpload()->uniqueName()->retainable();
            $form->hidden('status')->default(1);
        });
    }
}
