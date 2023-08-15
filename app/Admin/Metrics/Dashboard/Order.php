<?php


namespace App\Admin\Metrics\Dashboard;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Support\Facades\DB;

class Order extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('新訂單');
        $this->dropdown([
            '0' => '今日',
            '-1' => '昨日',
            '7' => '最近7天',
            '15' => '最近15天',
            '30' => '最近30天',

        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        /*$generator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };*/



        $by = 'd';
        switch ($request->get('option')) {
            case '30':
                $start = Carbon::now()->subDays(30);
                $end = Carbon::now()->endOfDay();
                break;
            case '15':

                $start = Carbon::now()->subDays(15);
                $end = Carbon::now()->endOfDay();
                break;
            case '7':
                $start = Carbon::now()->subDays(7);
                $end = Carbon::now()->endOfDay();
                break;
            case '-1':
                $start = Carbon::now()->subDay()->startOfDay();
                $end = Carbon::now()->subDay()->endOfDay();
                break;
            default:
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
                $by = 'H';

        }

        $count = \App\Models\Order::whereBetWeen('created_at',[$start,$end])->count();
        $data = \App\Models\Order::whereBetWeen('created_at',[$start,$end])
            ->selectRaw('DATE_FORMAT(created_at,"%'.$by.'") as day')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('day')
            ->pluck('count','day')->toArray();

        $cate = $this->cate($request->get('option')?:23);
        foreach ($cate as $k=>$v){
            $nk = $k;
            if($by=='d'){
                $nk = $k+1;
            }

            $nk = str_pad($nk,2,"0",STR_PAD_LEFT);
            if(isset($data[$nk])){
                $cate[$k] = $data[$nk];
            }
        }



        $this->withContent($count);
        $this->withChart($cate);
    }

    public function cate($c){
        $data = [];
        for ($i=0;$i<=$c;$i++){
            $data[] = 0;
        }
        return $data;
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ]

        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
HTML
        );
    }
}
