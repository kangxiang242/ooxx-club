<?php


namespace App\Http\Controllers\Web;


use App\Models\Faq;
use App\Models\Page;
use App\Repositories\NewRepository2;
use Illuminate\Http\Request;

class PageController extends BaseController
{



    public function index($uri,Request $request){


        $page = Page::where('uri','/'.trim($request->path(),'/'))->where('status',1)->first();
        if(!$page){
            abort(404);
        }


        return view('web.page',compact('page'));
    }

    public function about(){
        $faqs = Faq::where('status',1)->orderBy('sort')->get();
        return view('web.about',compact('faqs'));
    }



}
