<?php


namespace App\Repositories;



use App\Models\Area;
use Illuminate\Support\Facades\Cache;

class AreaRepository extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Area::class;



    public function all(){

        return Cache::rememberForever('areas', function () {
            return Area::where('parent_id',0)->where('status',1)->orderBy('sort')->get();
        });
    }


}
