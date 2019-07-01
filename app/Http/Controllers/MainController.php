<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\Address;
use App\Category;
use App\Comment;
use Illuminate\Support\Facades\DB;
use App\Food;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{

    public function getarea(Request $request){
        $arr = [];
        $address = Address::get();
        $city = $request->city;
        foreach($address as $add){
            if($add->city == $city){
                array_push($arr,$add->area);
            }
        }
        return response($arr);
    }


    // public function checkurl(Request $request){
    //     $groups = Groups::get();
    //     $temp = false;
    //     foreach($groups as $tmp){
    //         if($tmp->activate == "true"){
    //             $temp = URLs::where('group_id','=',$tmp->id)->where('url','=',$request->url)->exists();
    //             if($temp == true){
    //                 return 'true';
    //             }
    //         }
    //     }
    //     return 'false';
    // }

    // public function addGroup(Request $request)
    // {
	// 	$group = new Groups();
    //     $group->activate = 'false';
    //     $group->save();
	// 	return response($group->id, 200);
    // }

    // public function addurl(Request $request)
    // {
	// 	$url = new URLs();
    //     $url->url = $request->url;
    //     $url->group_id = $request->group_id;
    //     $url->save();
	// 	return response($url->id, 200);
    // }

    // public function removeurl(Request $request){
    //     $url = URLs::where('id','=',$request->id)->delete();
    //     return response('removed.',200);
    // }

    // public function activate(Request $request){
    //     $group = Groups::where('id','=',$request->id)->first();
    //     $group->activate='true';
    //     $group->save();
    //     return response('done');
    // }

    // public function deactivate(Request $request){
    //     $group = Groups::where('id','=',$request->id)->first();
    //     $group->activate='false';
    //     $group->save();
    //     return response('done');
    // }

    // public function getdata(Request $request){
    //     $arr = [];
    //     $groups = Groups::get();
    //     foreach($groups as $tmp){
    //         $temp = URLs::select('id','url')->where('group_id','=',$tmp->id)->get();
    //         array_push($arr,['group_id'=>$tmp->id,'activate'=>$tmp->activate,'urls'=>$temp]);
    //     }
    //     return response($arr);

    // }
}
