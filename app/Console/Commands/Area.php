<?php

namespace App\Console\Commands;

use App\Combine\Compose;
use App\Models\Config;
use App\Models\Product;
use App\Services\ConfigService;
use App\Services\ImageService;
use Illuminate\Console\Command;

class Area extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::get();
        $areas = \App\Models\Area::where('parent_id', 0)->where('status',1)->get();

        $areaCount = $areas->count();

        foreach ($products as $index => $product) {
            $area = $areas[$index % $areaCount];


            $names = explode(' ', $product->name);
            $name = end($names);
            $name = str_replace('約砲', '', $name);
            $name = str_replace('外送茶', '', $name);
            $name = str_replace('定點茶', '', $name);
            $name = str_replace('外約', '', $name);
            $name = str_replace('個工', '', $name);
            $name = str_replace('基隆', '', $name);
            $name = str_replace('臺北', '', $name);
            $name = str_replace('新北', '', $name);
            $name = str_replace('桃園', '', $name);
            $name = str_replace('新竹', '', $name);
            $name = str_replace('嘉義', '', $name);
            $name = str_replace('花蓮', '', $name);
            $name = str_replace('南投', '', $name);

            $product->name = $area->name.'約砲 '.$name;


            // 取对应的 area（循环）

            $product->area_city = $area->id;
            $product->area_county = 0;
            $product->save();
        }
    }
}
