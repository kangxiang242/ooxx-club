<?php

namespace App\Http\Controllers\Web;

use App\Handlers\ArticleAnchorsHandler;
use App\Http\Controllers\Controller;
use App\Models\Anchor;
use App\Models\Article;
use App\Models\ArticleCate;
use App\Models\Tag;
use App\Repositories\NewRepository2;
use Illuminate\Http\Request;

class  NewsController extends Controller
{
    private $newRepository;



    public function __construct(NewRepository2 $newRepository)
    {

        $this->newRepository = $newRepository;
    }

    public function index($uri=null){

        $article = Article::with('cate');

        if($uri){

            $curr = ArticleCate::where('uri',$uri)->where('status',1)->first();
            if(!$curr){
                abort(404);
            }

            $article = $article->where('article_cate_id',$curr->id);

        }

        $article = $article->where('status',1)->orderBy('sort','asc')->orderBy('created_at','desc')->paginate(9);

        $cate = ArticleCate::where('status',1)->orderBy('sort','asc')->get();

        return view('web.news.index',compact('article','cate'));
    }


    public function show($id){

        $news = $this->newRepository->find(intval($id));
        if(!$news){
            abort(404);
        }

        //$news->content = app(ArticleAnchorsHandler::class)->setAnchors($news->content,Anchor::get()->toArray());

        $news->content = app(ArticleAnchorsHandler::class)->btnGeneration($news->content);
        $recommend = $this->newRepository->recommend(4);
        $news->read_num += 1;
        $news->real_read_num +=1;
        $news->save();
        return view('web.news.show',compact('news','recommend'));

    }
}
