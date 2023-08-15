<?php


namespace App\Repositories;



use App\Models\Category;
use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

class FaqRepository extends Repository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Faq::class;


    public function all(){

        return Cache::rememberForever('faq', function () {
            return Faq::where('status',1)->orderBy('sort')->get();
        });
    }


}
