<?php


namespace App\Http\Controllers\Web;


use App\Models\Faq;
use App\Models\Page;
use App\Models\Topic;
use App\Repositories\NewRepository2;
use App\Repositories\QuickRepository;
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

    public function topic($title,QuickRepository $quickRepository){
        $recommend = app(NewRepository2::class)->recommend(4);
        $topic = Topic::where('title',$title)->where('status',1)->first();
        if(!$topic){
            abort(404);
        }
        $topics = Topic::where('status',1)->get();
        $quick = $quickRepository->all();
        return view('web.topic',compact('recommend','topic','topics','quick'));
    }



}
