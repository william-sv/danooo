<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Word\KoWord;
use App\Models\Word\UserKoWordPool;

class KoWordController extends BaseWordController
{
    protected string $wordModel = KoWord::class;
    protected string $wordPoolModel = UserKoWordPool::class;

}
