<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;

class TermController extends Controller
{
    // 利用規約ページ
    public function index()
    {
        $term = Term::first(); // 最初のレコードを取得
        return view('admin.terms.index', compact('term'));
    }

    // 編集ページ
    public function edit(Term $term)
    {
        return view('admin.terms.edit', compact('term'));
    }

    // 更新処理
    public function update(Request $request, Term $term)
    {
        // バリデーション
        $request->validate([
            'content' => 'required',
        ]);

        // データを更新
        $term->update($request->all());

        // フラッシュメッセージとリダイレクト
        return redirect()->route('admin.terms.index')->with('flash_message', '利用規約を編集しました。');
    }
}
