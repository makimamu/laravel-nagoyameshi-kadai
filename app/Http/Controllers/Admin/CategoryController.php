<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // カテゴリ一覧ページ
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $categories = Category::query()
            ->when($keyword, fn($query) => $query->where('name', 'like', "%$keyword%"))
            ->paginate(10);
        
        return view('admin.categories.index', [
            'categories' => $categories,
            'keyword' => $keyword,
            'total' => $categories->total(),
        ]);
    }

    // カテゴリ登録機能
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('flash_message', 'カテゴリを登録しました。');
    }

    // カテゴリ更新機能
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('flash_message', 'カテゴリを編集しました。');
    }

    // カテゴリ削除機能
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('flash_message', 'カテゴリを削除しました。');
    }
}