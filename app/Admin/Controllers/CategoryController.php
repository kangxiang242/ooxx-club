<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class CategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Category(), function (Grid $grid) {
            $grid->model()->orderBy('sort');
            $grid->column('name')->tree(true);
            $grid->column('status')->switch();
            $grid->column('sort')->orderable();
            $grid->column('created_at');
            $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                $create->select('parent_id','上級分類')->options(function(){
                    $cate = \App\Models\Category::where('parent_id',0)->pluck('name','id');
                    $select = ['0'=>'頂級分類'];
                    foreach($cate as $k=>$item){
                        $select[$k] = $item;
                    }
                    return $select;
                })->required()->default(0);
                $create->text('name')->required();
            });

            $grid->showQuickEditButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();

            $grid->quickSearch(['name']);
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
        return Show::make($id, new Category(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('name');
            $show->field('describe');
            $show->field('image');
            $show->field('status');
            $show->field('order');
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
        return Form::make(new Category(), function (Form $form) {
            $form->select('parent_id','上級分類')->options(function(){
                $cate = \App\Models\Category::where('parent_id',0)->pluck('name','id');
                $select = ['0'=>'頂級分類'];
                foreach($cate as $k=>$item){
                    $select[$k] = $item;
                }
                return $select;
            })->required()->default(0);
            $form->text('name')->required();
            //$form->text('describe');
            //$form->image('image')->uniqueName()->autoUpload();
            $form->switch('status')->default(1);
            $form->hidden('sort')->default(0);
            $form->saved(function (Form $form, $result) {
                Cache::forget('category');
            });
        });
    }
}
