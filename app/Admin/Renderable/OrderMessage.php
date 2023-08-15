<?php


namespace App\Admin\Renderable;

use App\Models\Message;
use App\Models\Order;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Grid;
use Illuminate\Support\Arr;

class OrderMessage extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new Order, function (Grid $grid) {

            $message = Message::find($this->payload['key']);

            /*$order = Order::find($this->payload['key']);*/
            $grid->model()->where('email',$message->email)->orWhere('name',$message->name)->orderBy('created_at','desc');

            $grid->column('no','訂單號');
            $grid->column('total_price','訂單總價');
            $grid->column('products','商品信息')->display(function($products){
                $html = "";
                foreach ($products as $item){
                    $html .= <<<HTML
                    <p><a target="_blank" href="/product/$item->product_id">$item->product_name</a><span>({$item->number}件)</span></p>
HTML;

                }
                return $html;
            });

            $grid->column('status','狀態')->display(function($status){
                return Arr::get(\App\Models\Order::STATUS_TXT,$status);
            });

            $grid->column('created_at','時間');

            $grid->paginate(5);

            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->disableBatchActions();
            $grid->disableFilter();
            $grid->disableRefreshButton();
            $grid->disableFilterButton();
            $grid->disableToolbar();

        });
    }
}
