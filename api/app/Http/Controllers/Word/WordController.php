<?php

namespace App\Http\Controllers\Word;

use Illuminate\Http\Request;
use App\Models\Word\KoWord;
use App\Models\Word\EnWord;
use App\Models\Word\JpWord;
use App\Models\Word\UserKoWordPool;
use App\Models\Word\UserJpWordPool;
use App\Models\Word\UserEnWordPool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class WordController extends BaseWordController
{

    public function __construct(Request $request)
    {
        $models = $this->getModel($request);
        parent::__construct($models[0],$models[1]);
    }

    protected array $models = [
        'ko' => [KoWord::class, UserKoWordPool::class],
        'jp' => [JpWord::class, UserJpWordPool::class],
        'en' => [EnWord::class, UserEnWordPool::class],
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
     * 初始化用户的单词池
     */
    public function initializeWordPool(Request $request)
    {
        // 先通过 getModel() 设置对应的模型
        $this->getModel($request); // 动态根据语言选择模型

        $userId = Auth::id();

        // 获取每天学习的单词数，默认为100
        $wordsPerDay = (int) $request->input('words_per_day', 100);
        if ($wordsPerDay <= 0) {
            return response()->json(['message' => 'Invalid words_per_day value.'], 400);
        }

        // 检查用户是否已初始化过单词池
        $existing = $this->wordPoolModel::where('user_id', $userId)->first();
        if ($existing) {
            return response()->json(['message' => 'Word pool already initialized.'], 200);
        }

        // 获取所有单词ID
        $allWordIds = $this->wordModel::select(['_id'])
            ->get()
            ->map(function ($item) {
                return (string) $item->_id;
            })
            ->toArray();
        if (empty($allWordIds)) {
            return response()->json(['message' => 'No words found.'], 400);
        }

        // 打乱单词顺序
        // shuffle($allWordIds);
        $allWordIds = Arr::shuffle($allWordIds);

        // 将打乱后的单词ID按用户设定的每天学习个数分割
        $chunks = array_chunk($allWordIds, $wordsPerDay);

        // 创建用户的单词池
        $userWordPool = new $this->wordPoolModel();
        $userWordPool->user_id = $userId;
        $userWordPool->word_ids = $chunks;  // 存储分割好的单词块
        $userWordPool->words_per_day = $wordsPerDay;
        $userWordPool->current_day = 1;  // 当前背诵从第1天开始
        $userWordPool->current_day_count = count($chunks);  // 当前背诵从第1天开始
        $userWordPool->created_at = now();
        $userWordPool->updated_at = now();
        $userWordPool->save();

        return response()->json(['message' => 'Word pool initialized successfully.'], 200);
    }

    public function ResetWordPool(Request $request)
    {
        $this->getModel($request); // 动态根据语言选择模型

        $userId = Auth::id();
        // wordPoolModel
        $this->wordPoolModel::where('user_id', $userId)->delete();
        $message = '用户单词池已清空';
        return $this->success($message);
    }

    public function ResetWordPoolCurrentDay(Request $request)
    {
        $this->getModel($request); // 动态根据语言选择模型

        $userId = Auth::id();
        // wordPoolModel current_day
        $this->wordPoolModel::where('user_id', $userId)->update(['current_day' => 1]);
        $message = '用户单词池当前进度已重置';
        return $this->success($message);
    }
}
