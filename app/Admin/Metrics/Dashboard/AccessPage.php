<?php


namespace App\Admin\Metrics\Dashboard;

use App\Admin\Metrics\Examples\NewUsers;
use App\Models\AccessLog;
use Carbon\Carbon;
use App\Admin\Metrics\Bar;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\ApexCharts\Chart;
class AccessPage extends Bar
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('頁面訪問排行(前10個)');

        $this->dropdown([
            '7' => '最近7天',
            '15' => '最近15天',
            '30' => '最近1個月',
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
        //$access_log = new AccessLog();
        $access_log = new \Jou\AccessLog\Models\AccessLog();

       /* switch ($request->get('option')) {
            case '30':

                $this->withChart([28, 40, 36, 52, 38, 60, 55,]);
                break;
            case '15':
                $this->withChart([28, 40, 36, 52, 38, 60, 55,]);
                break;
            case '7':
            default:
            $access_log->whereBetWeen('created_at',[Carbon::now()->subDays(7),Carbon::now()->endOfDay()])
            // 图表数据
            $this->withChart([28, 40, 36, 52, 38, 60, 55,]);

        }*/
        //dd(Carbon::now()->subDays($request->get('option',7)));
        //->selectRaw('url, count(id) as num')->groupBy('url')->orderBy('num','desc')
        $access_log = $access_log->where('method','GET')->whereBetWeen('created_at',[Carbon::now()->subDays($request->get('option',7)),Carbon::now()->endOfDay()])->selectRaw('url, count(id) as num')->groupBy('url')->orderBy('num','desc')->limit(10)->get();
        $categories = [];
        $data = [];
        foreach($access_log as $item){
            $categories[] = $item->url;
            $data[] = $item->num;
        }
        $this->withCategories($categories);
        $this->withChart($data);
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
            ],
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
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }
}
