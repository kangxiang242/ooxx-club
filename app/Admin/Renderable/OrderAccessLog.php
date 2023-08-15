<?php


namespace App\Admin\Renderable;


use App\Models\Order;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Grid;

class OrderAccessLog extends LazyRenderable
{
    public function grid(): Grid
    {

        return Grid::make(new \Jou\AccessLog\Models\AccessLog(), function (Grid $grid) {
            $order = Order::find($this->payload['key']);
            $grid->model()->where('ip',$order->ip)->orderBy('created_at','desc');

            $grid->column('url','URL');
            $grid->column('referer','來源')->limit(50);
            /*$grid->column('method','請求方式');*/
            $grid->column('created_at','時間');
            /*$grid->model()->where('user_id',$this->payload['id']);
            $grid->column('trade_at','交易時間')->sortable();


            $grid->column('order_no','订单号');
            $grid->column('price','交易金額')->display(function($price){
                $operate = $this->operate==2?"-":"+";
                return $operate.$price;
            });
            $grid->column('balance','餘額');
            $grid->column('remarks','交易备注');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('email','郵箱');
            });

            */
            $grid->paginate(10);

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
