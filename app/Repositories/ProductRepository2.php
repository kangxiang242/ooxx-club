<?php


namespace App\Repositories;


use App\Models\Product;
use Illuminate\Support\Facades\Cache;
class ProductRepository2 extends Repository2
{
    protected $modelClass = Product::class;

    public function get($is_cache=true){

        if (Cache::has(config('global.cache.products')) && $is_cache){
            $products = Cache::get(config('global.cache.products'));
        }else{
            $products = $this->model()->where('status',1)->orderBy('sort')->get();
            Cache::set(config('global.cache.products'),$products);
        }

        return $products;
    }


}
