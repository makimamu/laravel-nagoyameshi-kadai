<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // データ取得
        $highly_rated_restaurants = Restaurant::take(6)->get(); // 現時点では並び替えなし
        $categories = Category::all();
        $new_restaurants = Restaurant::orderBy('created_at', 'desc')->take(6)->get();

        // ビューに渡す
        return view('home', compact('highly_rated_restaurants', 'categories', 'new_restaurants'));
    }
}