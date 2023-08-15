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
            return Category::with('sub')->where('parent_id',0)->orderBy('sort')->get();
        });
    }


}
