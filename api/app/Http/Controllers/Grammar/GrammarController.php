<?php

namespace App\Http\Controllers\Grammar;

use Illuminate\Http\Request;
use App\Models\Grammar\KoGrammar;
use App\Models\Grammar\JpGrammar;
use App\Models\Grammar\EnGrammar;
use App\Models\Grammar\UserKoGrammarPool;
use App\Models\Grammar\UserJpGrammarPool;
use App\Models\Grammar\UserEnGrammarPool;
use Illuminate\Support\Facades\Auth;

class GrammarController extends BaseGrammarController
{
    /**
     * 初始化构造函数，传递动态选择的模型
     */
    public function __construct(Request $request)
    {
        
        $models = $this->getModel($request);
        parent::__construct($models[0],$models[1]);
    }

    protected array $models = [
        'ko' => [KoGrammar::class, UserKoGrammarPool::class],
        'jp' => [JpGrammar::class, UserJpGrammarPool::class],
        'en' => [EnGrammar::class, UserEnGrammarPool::class],
    ];

    protected function getModel(Request $request): array
    {
        $lang = strtolower($request->query('lang'));

        if (!isset($this->models[$lang])) {
            // abort(400, 'Invalid lang parameter.');
            $lang = 'ko';
        }
        return $this->models[$lang];
    }

    /**
     * 初始化用户的语法池
     */
    public function initializeGrammarPool(Request $request)
    {
        // 先通过 getModel() 设置对应的模型
        $model = $this->getModel($request); // 动态根据语言选择模型
        $this->grammarModel = $model[0];

        $userId = Auth::id();

        $grammarsPerDay = (int) $request->input('grammars_per_day', 20);
        if ($grammarsPerDay <= 0) {
            return response()->json(['message' => 'Invalid grammars_per_day value.'], 400);
        }

        $existing = $this->grammarPoolModel::where('user_id', $userId)->first();
        if ($existing) {
            return response()->json(['message' => 'Grammar pool already initialized.'], 200);
        }

        $allGrammarIds = $this->grammarModel::select(['_id'])
            ->get()
            ->map(function ($item) {
                return (string) $item->_id;
            })
            ->toArray();
        if (empty($allGrammarIds)) {
            return response()->json(['message' => 'No grammar points found.'], 400);
        }

        shuffle($allGrammarIds);
        $chunks = array_chunk($allGrammarIds, $grammarsPerDay);

        $userGrammarPool = new $this->grammarPoolModel();
        $userGrammarPool->user_id = $userId;
        $userGrammarPool->grammar_ids = $chunks;
        $userGrammarPool->grammars_per_day = $grammarsPerDay;
        $userGrammarPool->current_day = 1;
        $userGrammarPool->created_at = now();
        $userGrammarPool->updated_at = now();
        $userGrammarPool->save();

        return response()->json(['message' => 'Grammar pool initialized successfully.'], 200);
    }

    public function ResetGrammarPool(Request $request)
    {
        $this->getModel($request); // 动态根据语言选择模型

        $userId = Auth::id();
        // grammarPoolModel
        $this->grammarPoolModel::where('user_id', $userId)->delete();
        $message = '用户语法池已清空';
        return $this->success($message);
    }

    public function ResetGrammarPoolCurrentDay(Request $request)
    {
        $this->getModel($request); // 动态根据语言选择模型

        $userId = Auth::id();
        // grammarPoolModel current_day
        $this->grammarPoolModel::where('user_id', $userId)->update(['current_day' => 1]);
        $message = '用户语法池当前进度已重置';
        return $this->success($message);
    }

}
