<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller//class.子クラス.extends.親クラス【継承】
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
        return view('admin.restaurants.create');
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

        $restaurant = new Restaurant($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($path);
        } else {
            $restaurant->image = '';
        }

        $restaurant->save();

        return redirect()
            ->route('admin.restaurants.index')
            ->with('flash_message', '店舗を登録しました。');
    }

    // 店舗編集ページ
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
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

        $restaurant->fill($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($path);
        }

        $restaurant->save();

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
