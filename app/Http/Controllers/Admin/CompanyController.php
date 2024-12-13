<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();
        return view('admin.company.index', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'postal_code' => 'required|numeric|digits:7',
            'address' => 'required|string',
            'representative' => 'required|string',
            'establishment_date' => 'required|string',
            'capital' => 'required|string',
            'business' => 'required|string',
            'number_of_employees' => 'required|string',
        ]);

        $company->update($validated);

        return redirect()->route('admin.company.index')
                        ->with('flash_message', '会社概要を編集しました。');
    }
}