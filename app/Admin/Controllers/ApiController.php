<?php


namespace App\Admin\Controllers;



use App\Models\Area;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class ApiController extends AdminController
{
    public function getCity(){
        $area = Area::where('parent_id',0)->select(['id','name as text'])->get();
        return response()->json($area);
    }

    public function getCounty(Request $request){
        if($request->has('q')){
            $area = Area::where('parent_id',$request->get('q'))->select(['id','name as text'])->get();
            return response()->json($area);
        }

    }


}
