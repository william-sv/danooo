<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 获取请求头中的 API 密钥
        $authorization = $request->header('Authorization');
        
        if (!$authorization) {
            return response()->json(['message' => 'API key missing.'], 401);
        }

        // 去除开头的 "Bearer "（注意有个空格）
        if (str_starts_with($authorization, 'Bearer ')) {
            $apiKey = substr($authorization, 7); // 截掉前7个字符
        } else {
            $apiKey = $authorization;
        }

        // 验证 API 密钥是否存在于数据库中
        $user = User::where('api_key', $apiKey)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid API key.'], 403);
        }

        // 设置当前认证用户
        Auth::setUser($user);  // 将用户设置为当前的认证用户


        return $next($request);
    }
}
