<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = User::query();

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('kana', 'LIKE', "%{$keyword}%");
        }

        $users = $query->paginate(10);
        $total = $users->total();

        return view('admin.users.index', compact('users', 'keyword', 'total'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}