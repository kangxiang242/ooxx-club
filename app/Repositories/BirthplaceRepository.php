<?php


namespace App\Repositories;



use App\Models\Birthplace;
use App\Models\Quick;
use Illuminate\Support\Facades\Cache;

class BirthplaceRepository extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Quick::class;



    public function all(){

        return Cache::rememberForever('birthplace', function () {
            return Birthplace::orderBy('sort')->get();
        });
    }


}
