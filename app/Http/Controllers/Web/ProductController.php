<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductQuick;
use App\Models\ProductWithServe;
use App\Repositories\FaqRepository;
use App\Repositories\ProductAddedServeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;


class ProductController extends Controller
{
    public function index(Request $request){
        return view('web.product');
    }

    public function show($id,FaqRepository $faqRepository,ProductAddedServeRepository $productAddedServeRepository){

        $product = Cache::rememberForever('goods-'.$id, function () use ($id) {
            return Product::with(['birthplace','prices','withServes','city','county'])->find($id);
        });


        //$added = ProductAddedServe::where('product_id',$id)->get();
        $added = $productAddedServeRepository->getByProductId($id);

        $faqs = $faqRepository->all();

        return view('web.serve',compact('product','faqs','added'));
    }

    public function filter2(Request $request){

        $product = Product::with(['birthplace','quicks','withServes'])->where('status',1);

        $product_ids = collect();


        if($request->category){
            $category = $request->category;
            $category_product_ids = ProductCategory::whereIn('category_id',$category)->groupBy('product_id')->pluck('product_id');
            $product_ids = $product_ids->merge($category_product_ids);
        }



        if($request->serve){
            $serve = $request->serve;
            $serve_product_ids = ProductWithServe::whereIn('serve_id',$serve)->groupBy('product_id')->pluck('product_id');
            $product_ids = $product_ids->isNotEmpty() ? $product_ids->intersect($serve_product_ids)->values() : $product_ids->merge($serve_product_ids);
        }


        if($request->quick){
            $quick = $request->quick;
            $quick_product_ids = ProductQuick::whereIn('quick_id',$quick)->groupBy('product_id')->pluck('product_id');

            $product_ids = $product_ids->isNotEmpty() ? $product_ids->intersect($quick_product_ids)->values() : $product_ids->merge($quick_product_ids);

        }



        if($product_ids->isNotEmpty()){
            $product = $product->whereIn('id',$product_ids);
        }


        if($request->city){
            $product = $product->where('area_city',$request->city);
        }

        if($request->county){
            $product = $product->where('area_county',$request->county);
        }

        if($request->age){
            $age = $request->age;
            $product = $product->whereBetween('age',explode(',',$age));
        }

        if($request->price){
            $price = $request->price;
            $product = $product->whereBetween('price_start',explode(',',$price));
        }


        if($request->cup){
            $cup = $request->cup;
            $product = $product->whereIn('cup',$cup);
        }

        if($request->height){
            $height = $request->height;
            $product->where(function($query)use($height){
                if(in_array(1,$height)){
                    $query->where('height','<=',160);
                }
                if(in_array(2,$height)){
                    $query->orWhereBetween('height',[160,170]);
                }
                if(in_array(3,$height)){
                    $query->orWhere('height','>=',170);
                }
            });
        }

        if($request->weight){
            $weight = $request->weight;
            $product->where(function($query)use($weight){
                if(in_array(1,$weight)){
                    $query->where('weight','<=',50);
                }
                if(in_array(2,$weight)){
                    $query->orWhereBetween('weight',[50,60]);
                }
                if(in_array(3,$weight)){
                    $query->orWhere('weight','>=',60);
                }
            });
        }

        if($request->birthplace){
            $birthplace = $request->birthplace;
            if(in_array('western',$birthplace)){
                $birthplace = array_diff($birthplace,['western']);
                $birthplace = array_merge($birthplace,[9,10,11,12]);
            }

            $product = $product->whereIn('birthplace_id',$birthplace);
        }


        $tab = 0;
        if($request->tab){
            $tab = $request->tab;
        }else if(Cookie::has('selected_type')){
            $selected_type = Cookie::get('selected_type');
            $tab = $selected_type;
        }

        if($tab == 1 || $tab == 2){
            $product = $tab==1?$product->where('outgoing',1):$product->where('fixation',1);
        }


        $product = $product->orderBy('sort')->paginate($request->get('limit',20));

        $html =  view('render.goods',compact('product'))->render();

        $response = [
            'current_page'=>$product->currentPage(),
            'last_page'=>$product->lastPage(),
            'per_page'=>$product->perPage(),
            'total'=>$product->total(),
            'render'=>$html,
        ];
        return response()->json($response);
    }

}
