<?php


namespace App\Admin\Renderable;


use App\Admin\Actions\Grid\TagProductRemove;
use App\Admin\Repositories\Product;
use App\Models\ProductTag;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class TagProductGrid extends LazyRenderable
{

    public function grid(): Grid
    {
        Admin::style(<<<STYLE
.modal-content{background-color: #eff1f7;    border: 1px solid #d9d9d9;}
STYLE
);

        $id = $this->payload['key'];

        $productTag = ProductTag::with(['product'=>function($query){
            $query->select(['id','code','name','img']);
        }])->where('tag_id',$id);

        return Grid::make($productTag, function (Grid $grid) {
            $grid->column('product_id','產品ID');
            $grid->column('product.code','編號');
            $grid->column('product.name','名稱');
            $grid->quickSearch(['product_id','product.code','product.name']);
            $grid->disableRowSelector();
            $grid->paginate(10);
            $grid->actions(function(Grid\Displayers\Actions $actions){
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
                $actions->append(new TagProductRemove);
            });

        });
    }


}
