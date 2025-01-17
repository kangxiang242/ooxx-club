<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\QuickRepository;


class IndexController extends Controller
{
    public function index(QuickRepository $quickRepository){
        $quick = $quickRepository->all();
        $covers = Product::orderBy('sort')->pluck('cover');
        return view('web.index',compact('quick','covers'));
    }


}
