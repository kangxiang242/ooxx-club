<?php


namespace App\Admin\Metrics\Dashboard;



use App\Models\AccessLog;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;

/**
 * Class NewDevices
 * @package App\Admin\Metrics\Dashboard
 */
class NewDevices extends Donut
{
    protected $labels = ['Desktop', 'Mobile'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('新設備');
        $this->subTitle('最近7天');
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
    }

    /**
     * 渲染模板
     *
     * @return string
     */
    public function render()
    {
        $this->fill();

        return parent::render();
    }

    /**
     * 写入数据.
     *
     * @return void
     */
    public function fill()
    {

        $mobile_count = AccessLog::whereBetWeen('created_at',[Carbon::now()->subDays(7),Carbon::now()->endOfDay()])->whereIn('device',['iphone','android'])->count();
        $pc_count = AccessLog::whereBetWeen('created_at',[Carbon::now()->subDays(7),Carbon::now()->endOfDay()])->whereNotIn('device',['iphone','android'])->count();

        $this->withContent($pc_count, $mobile_count);

        // 图表数据
        $this->withChart([$pc_count, $mobile_count]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return \App\Admin\Metrics\Examples\NewDevices
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $desktop
     * @param mixed $mobile
     *
     * @return $this
     */
    protected function withContent($desktop, $mobile)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$desktop}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$mobile}</div>
</div>
HTML
        );
    }
}
