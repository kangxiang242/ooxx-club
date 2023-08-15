<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamController extends Controller
{
    public function detail($id){
        $team = Team::where('id',$id)->where('status',1)->first();
        if(!$team){
            abort(404);
        }
        return view('web.team-detail',compact('team'));
    }

    public function about($id){
        $team = Team::where('id',$id)->where('status',1)->first();

        if(!$team){
            abort(404);
        }
        return view('web.team-about',compact('team'));
    }
}
