<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        // 验证请求数据
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email'
        ]);

        // 创建新用户
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // 生成 API 密钥
        $user->api_key = Str::random(32);  // 生成32个字符的随机字符串作为 API 密钥

        // 保存用户信息
        $user->save();

        return response()->json([
            'message' => 'User created successfully.',
            'api_key' => $user->api_key,  // 返回生成的 API 密钥
        ], 201);
    }
}
