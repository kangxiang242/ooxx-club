<?php


namespace App\Repositories;


use App\Models\ProductAddedServe;
use Illuminate\Support\Facades\Cache;

class ProductAddedServeRepository extends Repository
{

    public function all(){
        return Cache::rememberForever('product-added-serve', function () {
            return ProductAddedServe::get();
        });
    }

    public function getByProductId($product_id){
        return $this->all()->where('product_id',$product_id)->values();

    }


}
