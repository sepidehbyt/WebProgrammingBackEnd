<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\Address;
use App\Category;
use App\Comment;
use App\Food;
use App\CategoryToRestaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{

    public function getarea(Request $request){
        $address = Address::where('city','=',$request->city)->select('area')->get();
        return (response()->json($address));
    }

    public function getrestaurants(Request $request){
        $area = $request->area;
        $city = $request->city;
        $category = $request->category;
        if($area <> null) {
            $addressIds = Address::where('area','=',$area)->where('city','=',$city)->select('id')->get();
        }
        else {
            $addressIds = Address::where('city','=',$city)->select('id')->get();
        }
        if($category <> null) {
            $category_arr = explode(',', $category);
            $categoryIds = Category::whereIn('name',$category_arr)->select('id')->get();
        }
        else {
            $categoryIds = Category::select('id')->get();
        }
        $restaurantIds = CategoryToRestaurant::whereIn('category_id', $categoryIds)->select('restaurant_id')->get();
        $allRestaurants = Restaurant::whereIn('address_id',$addressIds)->whereIn('id',$restaurantIds)->get();
        $hour=(int)(date("H"));
        $openRestaurants = [];
        $closeRestaurants = [];
        foreach($allRestaurants as $restaurant) {
            if($restaurant->opening_time <= $hour and $restaurant->closing_time >= $hour) {
                array_push($openRestaurants, $restaurant);
            }
            else {
                array_push($closeRestaurants, $restaurant);
            }
        }
        return (response()->json([
            'area'=> $area,
            'city'=>$city,
            'addressId'=>$addressIds,
            'categoryIds'=>$categoryIds,
            'restaurantIds'=>$restaurantIds,
            'allRestaurantsSize'=>sizeof($allRestaurants),
            'allRestaurants'=>$allRestaurants,
            'openRestaurants'=>$openRestaurants,
            'closeRestaurants'=>$closeRestaurants,
            'hour'=>$hour
            ]));
    }

    public function getrestaurantdata($id){

        return (response()->json([
            'chiz'=>$id
            // 'area'=> $area,
            // 'city'=>$city,
            // 'addressId'=>$addressIds,
            // 'categoryIds'=>$categoryIds,
            // 'restaurantIds'=>$restaurantIds,
            // 'allRestaurantsSize'=>sizeof($allRestaurants),
            // 'allRestaurants'=>$allRestaurants,
            // 'openRestaurants'=>$openRestaurants,
            // 'closeRestaurants'=>$closeRestaurants,
            // 'hour'=>$hour
            ]));
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
