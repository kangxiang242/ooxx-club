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
        $areas = Area::where('parent_id', 0)->get();

        $areaCount = $areas->count();

        foreach ($products as $index => $product) {
            // 取对应的 area（循环）
            $area = $areas[$index % $areaCount];

            $product->area_city = $area->id;
            $product->area_county = 0;
            $product->save();
        }
    }
}
