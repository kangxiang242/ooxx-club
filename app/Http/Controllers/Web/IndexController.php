<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Repositories\QuickRepository;


class IndexController extends Controller
{
    public function index(QuickRepository $quickRepository){
        $quick = $quickRepository->all();
        return view('web.index',compact('quick'));
    }


}
