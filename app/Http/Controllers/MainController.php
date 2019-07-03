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
use Carbon\Carbon;

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
        $restaurant = Restaurant::where('id','=',$id)->get();
        $address = Address::where('id','=',$restaurant[0]->address_id)->get();
        $foodSets = Food::where('restaurant_id','=',$id)->groupBy('food_set')->select('food_set')->get();
        $foods = [];
        foreach($foodSets as $foodSet) {
            $temp = Food::where('restaurant_id','=',$id)->where('food_set','=',$foodSet->food_set)->get();
            array_push($foods, ['foodSet' => $foodSet, 'foods' => $temp]);
        }
        $comments = Comment::where('restaurant_id','=',$id)->orderBy('created_at', 'desc')->get();
        $averageRate = 0;
        foreach($comments as $comment) {
            $temp = $comment->quality + $comment->packaging + $comment->delivery_time + $comment->delivery_react;
            $temp/=4;
            $averageRate += $temp;
        }
        $averageRate /= sizeof($comments);

        return (response()->json([
            'restaurant'=>$restaurant,
            'address'=>$address,
            'foodSets'=>$foodSets,
            'foods'=>$foods,
            'comments'=>$comments,
            'averageRate'=>$averageRate,
            ]));
    }

    public function getcomments($id){
        $comments = Comment::where('restaurant_id','=',$id)->orderBy('created_at', 'desc')->get();
        return (response()->json([
            'comments'=>$comments,
            ]));
    }

    public function postcomment($id, Request $request){
        $comment = new Comment([
            'author' => $request->author,
            'quality' => $request->quality,
            'packaging' => $request->packaging,
            'delivery_time' => $request->delivery_time,
            'delivery_react' => $request->delivery_react,
            'restaurant_id' => $id,
            'text' => $request->text,
            'created_at' => Carbon::now()
        ]);
        $comment->save();
        return response()->json([
            'message' => '#successCommentSave'
        ], 200);
    }

    public function addrestaurants(Request $request){
        $request = json_decode($request->getContent());
        $address = $request->address;
        $tempAddress = new Address([
            'city' => $address->city,
            'area' => $address->area,
            'address_line' => $address->address_line,
            'created_at' => Carbon::now()
        ]);
        $tempAddress->save();

        $restaurant = new Restaurant([
            'name' => $request->name,
            'logo' => $request->logo,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'average_rate' => $request->average_rate,
            'address_id' => $tempAddress->id,
        ]);
        $restaurant->save();

        $categories = $request->categories;
        foreach($categories as $category) {
            $categoryId = Category::where('name','=',$category->name)->select('id')->first();
            if($categoryId <> null) {
                $categoryToRestaurant = new CategoryToRestaurant([
                    'restaurant_id' => $restaurant->id,
                    'category_id' => $categoryId->id
                ]);
                $categoryToRestaurant->save();
            }
        }

        $foods = $request->foods;
        foreach($foods as $food) {
            $tempFood = new Food([
                "name" => $food->name,
                "price" => $food->price,
                "description" => $food->description,
                "food_set" => $food->food_set,
                "restaurant_id" => $restaurant->id
            ]);
            $tempFood->save();
        }

        return response()->json([
            'message' => '#successRestaurantSave'
        ], 200);
    }

}
