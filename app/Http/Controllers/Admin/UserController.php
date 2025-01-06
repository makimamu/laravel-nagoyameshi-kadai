<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // ユーザー一覧ページの表示
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

    // ユーザー詳細ページの表示
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // 会員情報ページの表示
    public function showUserInfo()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }

    // 会員情報編集ページの表示
    public function editUserInfo(User $user)
    {
        // 他人の会員情報を編集できないようにする
        if ($user->id !== Auth::id()) {
            return redirect()->route('user.index')->with('error_message', '不正なアクセスです。');
        }
        return view('user.edit', compact('user'));
    }

    // 会員情報の更新
    public function updateUserInfo(Request $request, User $user)
    {
        // 他人の会員情報を編集できないようにする
        if ($user->id !== Auth::id()) {
            return redirect()->route('user.index')->with('error_message', '不正なアクセスです。');
        }

        // バリデーションルールの定義
        $validationRules = [
            'name' => 'required|string|max:255',
            'kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー]+$/u'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'postal_code' => 'required|digits:7',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|digits_between:10,11',
            'birthday' => 'nullable|digits:8',
            'occupation' => 'nullable|string|max:255',
        ];

        // バリデーション
        $validated = $request->validate($validationRules);

        // データの更新
        $user->update($validated);

        return redirect()->route('user.index')->with('flash_message', '会員情報を編集しました。');
    }
}