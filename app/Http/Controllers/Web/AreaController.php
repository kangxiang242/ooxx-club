<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Area;

class AreaController extends Controller
{

    public function get(){
        $area = Area::with(['sub'=>function($query){
            $query->select('id','parent_id','name')->where('status',1)->orderBy('sort');
        }])->select('id','name')->where('parent_id',0)->orderBy('sort')->get();
        return response()->json($area);
    }





}
