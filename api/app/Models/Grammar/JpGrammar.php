<?php

namespace App\Models\Grammar;


use MongoDB\Laravel\Eloquent\Model;

class KoGrammar extends Model
{
    protected $connection = 'mongodb'; // 指定连接
    protected $collection = 'jp_grammars'; // 指定集合名称

    
}
