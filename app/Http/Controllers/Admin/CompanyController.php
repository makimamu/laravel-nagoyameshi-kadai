<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    // 会社概要ページ
    public function index()
    {
        $company = Company::first(); // 最初のレコードを取得
        return view('admin.company.index', compact('company'));
    }

    // 編集ページ
    public function edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }

    // 更新処理
    public function update(Request $request, Company $company)
    {
        // バリデーションを行い、$validatedData に格納
        $validatedData = $request->validate([
            'name' => 'required',
            'postal_code' => 'required|numeric|digits:7',
            'address' => 'required',
            'representative' => 'required',
            'establishment_date' => 'required',
            'capital' => 'required',
            'business' => 'required',
            'number_of_employees' => 'required',
        ]);
    
        // バリデーションされたデータで更新
        // マスアサインメントを使用して更新
    $company->update($validatedData);

        // フラッシュメッセージとリダイレクト
        return redirect()->route('admin.company.index')->with('flash_message', '会社概要を編集しました。');
    }
}
