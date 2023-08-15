<?php


namespace App\Extensions\Tools;

use App\Models\Order;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Dropdown;
class OrderStatusBatchAction extends BatchAction
{


    protected $action;

    // 注意action的构造方法参数一定要给默认值
    public function __construct($title = null, $action = 1)
    {
        $this->title = $title;
        $this->action = $action;
    }

    // 确认弹窗信息
    public function confirm()
    {
        return '確定將選中訂單改爲'.$this->title.'？';
    }

    // 处理请求
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();

        // 获取请求参数
        $action = $request->get('action');

        Order::whereIn('id',$keys)->update([
            'status'=>$action
        ]);

        return $this->response()->success("操作成功")->refresh();
    }


    // 设置请求参数
    public function parameters()
    {
        return [
            'action' => $this->action,
        ];
    }


}
