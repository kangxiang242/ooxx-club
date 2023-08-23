<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Audio;
use App\Models\Birthplace;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cookie;

class AudioController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        if(!request()->has('_selector')){
            $url = admin_url('audio?_selector[birthplace_id]=1');
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$url);
            exit;
        }
        $_selector = request()->get('_selector');
        $type = array_get($_selector,'birthplace_id',1);
        Cookie::queue('selected_audio_birthplace_id',array_get($_selector,'birthplace_id',1));
        return Grid::make(new Audio(), function (Grid $grid) use ($type) {
            $grid->model()->where('type',$type);
            $grid->column('audio')->link(function (){
                return asset_upload($this->audio);
            });
            $grid->column('duration');
            $grid->column('status')->switch();
            $grid->column('created_at');

            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();
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
            if($form->isCreating()){
                $form->hidden('birthplace_id')->value(Cookie::get('selected_audio_birthplace_id'));
            }
            $form->file('audio')->autoUpload()->uniqueName()->retainable()->accept('mp3')->chunkSize(256);
            $form->number('duration')->default(15)->help('單位/秒');
            $form->hidden('status')->default(1);
        });
    }
}
