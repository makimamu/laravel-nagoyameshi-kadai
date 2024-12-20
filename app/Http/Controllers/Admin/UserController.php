<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     * 会員一覧ページ
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword'); // 検索キーワード

        // 検索処理
        if ($keyword !== null) {
            $users = User::where('name', 'like', "%{$keyword}%")
                ->orWhere('kana', 'like', "%{$keyword}%")
                ->paginate(15);
            $total = $users->total();
        } else {
            $users = User::paginate(15); // ページネーション
            $total = User::count(); // 総件数
            $keyword = null;
        }
        return view('admin.users.index', compact('users', 'keyword', 'total'));
    }
    /**
     * Display the specified resource.
     * 詳細ページ
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
