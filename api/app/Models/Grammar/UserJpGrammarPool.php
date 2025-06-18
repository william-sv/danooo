<?php

namespace App\Models\Grammar;


use MongoDB\Laravel\Eloquent\Model;

class UserJpGrammarPool extends Model
{
    protected $collection = 'user_jp_grammar_pool'; // 针对韩语

    // 定义允许批量赋值的字段
    protected $fillable = [
        'user_id',             // 用户ID
        'grammar_ids',         // 每天的语法分块数组
        'grammars_per_day',    // 每天学习的语法数
        'current_day',         // 当前天数
        'created_at',          // 创建时间
        'updated_at',          // 更新时间
    ];

    // 定义数据类型转换
    protected $casts = [
        'grammar_ids' => 'array',  // 确保 grammar_ids 被存储为数组
    ];
}
