<?php

namespace App\Http\Controllers\Web;

use App\Handlers\ArticleAnchorsHandler;
use App\Http\Controllers\Controller;
use App\Models\Anchor;
use App\Models\ArticleCate;
use App\Models\Cases;
use App\Models\Product;
use App\Repositories\NewRepository2;
use App\Repositories\ProductRepository2;
use Illuminate\Http\Request;

class CaseController extends Controller
{


    public function index($id = 0){


        $cases = Cases::with('product')->where('status',1);

        if($id){
            $cases = $cases->where('product_id',$id);
        }

        $cases = $cases->orderBy('sort')->get();

        $products = app(ProductRepository2::class)->get();

        $goods = null;
        if($id){
            $goods = Product::find($id);

        }

        return view('web.case',compact('cases','products'))->with('id',$id)->with('goods',$goods);
    }


    public function show($id){

        $case = Cases::find($id);
        return view('web.case-detail',compact('case'));

    }
}
