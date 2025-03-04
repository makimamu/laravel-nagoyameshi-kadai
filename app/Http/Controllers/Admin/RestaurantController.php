<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    // 店舗一覧ページ
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $query = Restaurant::query();

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $restaurants = $query->paginate(10);
        $total = $restaurants->total();

        return view('admin.restaurants.index', compact('restaurants', 'keyword', 'total'));
    }

    // 店舗詳細ページ
    public function show(Restaurant $restaurant)
    {
        return view('admin.restaurants.show', compact('restaurant'));
    }

    // 店舗登録ページ
    public function create()
    {
        $categories = Category::all();
        return view('admin.restaurants.create', compact('categories'));
    }

    // 店舗登録機能
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048',
            'description' => 'required',
            'lowest_price' => 'required|integer|min:0|lte:highest_price',
            'highest_price' => 'required|integer|min:0|gte:lowest_price',
            'postal_code' => 'required|digits:7',
            'address' => 'required',
            'opening_time' => 'required|before:closing_time',
            'closing_time' => 'required|after:opening_time',
            'seating_capacity' => 'required|integer|min:0',
        ]);

        // レストランを作成
        $restaurant = Restaurant::create($validated);

        // 画像の処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($path);
            $restaurant->save();
        }

        // category_ids を取得し、空の値を取り除く
        $category_ids = array_filter($request->input('category_ids', []));

        // カテゴリの紐付け
        $restaurant->categories()->sync($category_ids);

        return redirect()
            ->route('admin.restaurants.index')
            ->with('flash_message', '店舗を登録しました。');
    }

    // 店舗編集ページ
    public function edit(Restaurant $restaurant)
{
    $categories = Category::all();
    $category_ids = $restaurant->categories->pluck('id')->toArray(); // ここでカテゴリIDの配列を取得

    return view('admin.restaurants.edit', compact('restaurant', 'categories', 'category_ids'));
}
    // 店舗更新機能
    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048',
            'description' => 'required',
            'lowest_price' => 'required|integer|min:0|lte:highest_price',
            'highest_price' => 'required|integer|min:0|gte:lowest_price',
            'postal_code' => 'required|digits:7',
            'address' => 'required',
            'opening_time' => 'required|before:closing_time',
            'closing_time' => 'required|after:opening_time',
            'seating_capacity' => 'required|integer|min:0',
        ]);

        $restaurant->update($validated);

        // 画像の処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($path);
            $restaurant->save();
        }

        // category_ids を取得し、空の値を取り除く
        $category_ids = array_filter($request->input('category_ids', []));

        // カテゴリの紐付けを更新
        $restaurant->categories()->sync($category_ids);

        return redirect()
            ->route('admin.restaurants.index')
            ->with('flash_message', '店舗を更新しました。');
    }

    // 店舗削除機能
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()
            ->route('admin.restaurants.index')
            ->with('flash_message', '店舗を削除しました。');
    }
}