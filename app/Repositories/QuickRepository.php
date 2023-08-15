<?php


namespace App\Repositories;



use App\Models\Quick;
use Illuminate\Support\Facades\Cache;
class QuickRepository extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Quick::class;



    public function all(){

        return Cache::rememberForever('quick', function () {
            return Quick::orderBy('sort')->get();
        });
    }


}
