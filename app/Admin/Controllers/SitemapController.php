<?php


namespace App\Admin\Controllers;

use App\Models\Config;
use App\Models\Product;
use App\Services\ConfigService;
use App\Services\SitemapService;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;
use Rizhou\PageCache\PageCache;

class SitemapController extends AdminController
{
    /**
     * 更新sitemap
     * @return mixed|void
     */
    public function store()
    {
        app(SitemapService::class)->generate();
        admin_toastr('sitemap.xml更新成功', 'success', ['timeOut' => 3000]);
        return redirect(admin_url());
    }

    public function clearRedis(){
        $config = Config::where('name','asset_version')->first();
        if($config){
            $config->content = $config->content+1;
            $config->save();
        }else{
            Config::create([
                'name'=>'asset_version',
                'content'=>'10000',
            ]);
        }

        try {
            file_get_contents("http://111.90.143.211/cache_clear.php");
            file_get_contents("http://45.148.120.127/cache_clear.php");
        }catch (\Exception $e){}


        /*ConfigService::cache();

        Cache::forget('birthplace');

        Cache::forget('category');

        Cache::forget('faq');

        Cache::forget('quick');

        Cache::forget('serve');

        Cache::forget('seo');

        $product = Product::all();
        foreach ($product as $item){
            Cache::forget('goods-'.$item->id);
        }*/

        admin_toastr('缓存清除成功', 'success', ['timeOut' => 3000]);
        return redirect(admin_url());
    }
}
