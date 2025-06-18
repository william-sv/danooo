<?php

namespace App\Models\Word;

use MongoDB\Laravel\Eloquent\Model;

class KoWord extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ko_words';

    protected $primaryKey = '_id';
    // 指定主键类型为字符串
    protected $keyType = 'string';

    protected $fillable = [
        'word',          // 韩语单词
        'romanization',  // 罗马拼音
        'meanings',      // 多词义数组
        'metadata',      // 元数据
        'wordId',        // 单词唯一标识符
    ];

    protected $casts = [
        'meanings' => 'array',    // 确保存储为嵌套数组
        'metadata' => 'array',    // 元数据转换为数组
        '_id' => 'string',        // ObjectId 转换为字符串
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
