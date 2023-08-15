<?php


namespace App\Repositories;


use App\Models\Serve;
use Illuminate\Support\Facades\Cache;

class ServeRepository extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Serve::class;



    public function all(){
        return Cache::rememberForever('serve', function () {
            return Serve::get();
        });
    }


}
