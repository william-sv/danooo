<?php

namespace App\Http\Controllers;

use App\Models\Grammar\KoGrammar;
use App\Http\Controllers\Grammar\BaseGrammarController;
use App\Models\Grammar\UserKoGrammarPool;

class KoGrammarController extends BaseGrammarController
{
    protected string $grammarModel = KoGrammar::class;
    protected string $grammarPoolModel = UserKoGrammarPool::class;
}
