<?php

namespace App\Models\Grammar;


use MongoDB\Laravel\Eloquent\Model;

class KoGrammar extends Model
{
    protected $connection = 'mongodb'; // 指定连接
    protected $collection = 'ko_grammars'; // 指定集合名称

    protected $primaryKey = '_id';
    // 指定主键类型为字符串
    protected $keyType = 'string';

    protected $fillable = [
        'version',
        'grammarId',
        'grammarForm',
        'appliesTo',
        'description',
        'conjugationRules',
        'semanticFeatures',
        'meaning',
        'relatedGrammar',
    ];

    protected $casts = [
        'appliesTo' => 'array',
        'description' => 'array',
        'conjugationRules' => 'array',
        'semanticFeatures' => 'array',
        'meaning' => 'array',
        'relatedGrammar' => 'array',
    ];
}
