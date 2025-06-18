<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    protected $connection = 'mongodb';  // 指定 MongoDB 连接
    protected $collection = 'users';
    protected $fillable = ['name', 'email', 'api_key'];  // 允许批量赋值的字段
    protected $hidden = ['api_key'];  // 隐藏 API 密钥（确保不被暴露）
    // 强制类型转换
    protected $casts = [
        '_id' => 'string', // 确保 _id 返回字符串，避免认证时出错
    ];

    /**
     * 获取用户的认证标识字段名
     */
    public function getAuthIdentifierName()
    {
        return '_id';
    }

    /**
     * 获取用户的认证标识
     */
    public function getAuthIdentifier()
    {
        return (string) $this->_id;
    }

    /**
     * 获取用户的密码（如果有）
     */
    public function getAuthPassword()
    {
        // 你当前结构里没 password 字段，直接返回 null
        return null;
    }

    /**
     * 获取 "记住我" token
     */
    public function getRememberToken()
    {
        return $this->remember_token ?? null;
    }

    /**
     * 设置 "记住我" token
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * 获取 "记住我" token 的字段名
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
