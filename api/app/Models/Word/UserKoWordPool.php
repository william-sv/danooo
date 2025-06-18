<?php

namespace App\Models\Word;


use MongoDB\Laravel\Eloquent\Model;

class UserKoWordPool extends Model
{
    protected $collection = 'user_ko_word_pool'; // 针对韩语

    // 定义允许批量赋值的字段
    protected $fillable = [
        'user_id',           // 用户ID
        'word_ids',          // 每天的单词分块数组
        'words_per_day',     // 每天学习的单词数
        'current_day',       // 当前天数
        'current_day_count', // 当前天数
        'created_at',        // 创建时间
        'updated_at',        // 更新时间
    ];

    // 定义数据类型转换
    protected $casts = [
        'word_ids' => 'array',  // 确保 word_ids 被存储为数组
    ];
}
