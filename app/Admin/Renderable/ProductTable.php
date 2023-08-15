<?php


namespace App\Admin\Renderable;


use App\Admin\Actions\Grid\TagProductRemove;
use App\Models\Brand;
use App\Models\Cate;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Spu;
use App\Models\Tag;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Illuminate\Support\Facades\DB;

class ProductTable extends LazyRenderable
{

    public function grid(): Grid
    {
        Admin::style(<<<STYLE
.modal-content{background-color: #eff1f7;    border: 1px solid #d9d9d9;}
STYLE
);
        $product = new Product;

        if(isset($this->payload['spu_id']) && $this->payload['spu_id'] > 0){
            $spu = Spu::find($this->payload['spu_id']);
            $product = $product->where('spu_id',0)->orWhere('spu_id',$spu->id)->orderBy('spu_id','desc');
        }

        if(isset($this->payload['tag_id']) && $this->payload['tag_id'] > 0){
            $tag = Tag::with('products')->find($this->payload['tag_id']);
            if($tag->products){
                $product = $product->orderByRaw(DB::raw("FIND_IN_SET(id, '" . implode(',',$tag->products->pluck('id')->toArray()) . "'" . ') desc'));
            }
        }

        if(isset($this->payload['ids']) && $this->payload['ids']){
            $product = $product->orderByRaw(DB::raw("FIND_IN_SET(id, '" . $this->payload['ids'] . "'" . ') desc'));
        }



        return Grid::make($product, function (Grid $grid){
            $grid->column('id','ID');
            $grid->column('code','編號');
            $grid->column('name','名稱');
            $grid->filter(function($filter){
                $filter->panel();
                $filter->like('name')->width(6);
                $filter->equal('brand_id','品牌')->select(Brand::pluck('name','id'))->width(6);
                $filter->equal('cate.cate_id','分類')->checkbox(Cate::where('pid','>',0)->pluck('name','id'))->width(12);

            });


            $grid->paginate(20);
            $grid->disableActions();


        });
    }


}
