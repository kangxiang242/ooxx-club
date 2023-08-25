<?php


namespace App\Repositories;



use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Category::class;



    public function all(){

        return Cache::rememberForever('category', function () {
            return Category::with(['sub'=>function($query){
                $query->where('status',1);
            }])->where('parent_id',0)->where('status',1)->orderBy('sort')->get();
        });
    }


}
