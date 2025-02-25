<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //カテゴリ一覧ページ

    public function index(Request $request)
{
    //検索機能
    $keyword = $request->input('keyword');
    $query = Category::query();

    if ($keyword) {
        $query->where('name', 'LIKE', "%{$keyword}%");
    }

    $categories = $query->paginate(10);
    $total = $categories->total();

    return view('admin.categories.index', compact('categories', 'keyword', 'total'));
}

//カテゴリ登録機能
        public function store(Request $request)
{
    $request->validate([
        'name' => 'required'
    ]);

    Category::create([
        'name' => $request->name
    ]);

    return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを登録しました。');
}
//カテゴリ更新機能
public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required'
    ]);

    $category->update([
        'name' => $request->name
    ]);

    return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを編集しました。');
}
//カテゴリ消去機能
public function destroy(Category $category)
{
    $category->delete();

    return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを削除しました。');
    }

}
