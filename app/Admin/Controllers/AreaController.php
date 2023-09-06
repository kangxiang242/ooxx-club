<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Area;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AreaController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(new Area(), function (Grid $grid) {

            $grid->model()->where('parent_id',0)->orderBy('sort');
            $grid->column('name');
            $grid->column('sort','排序')->orderable();
            $grid->column('status','狀態')->switch();
            $grid->column('weight','权重')->editable();
            $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                $create->select('parent_id','上級分類')->options(function(){
                    $cate = \App\Models\Area::where('parent_id',0)->pluck('name','id');
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
        return Show::make($id, new Area(), function (Show $show) {
            $show->field('id');
            $show->field('parent_id');
            $show->field('name');
            $show->field('level');
            $show->field('code');
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
        return Form::make(new Area(), function (Form $form) {

            $form->text('parent_id');
            $form->text('name');
            $form->text('level');
            $form->text('code');
            $form->hidden('weight')->default(1);
            $form->hidden('status')->default(1);

        });
    }
}
