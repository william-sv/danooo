<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseWordController extends BaseController
{
    protected string $wordModel;
    protected string $wordPoolModel;

    public function __construct($wordModel, $wordPoolModel)
    {
        // 如果没有传递模型，提供默认值
        $this->wordModel = $wordModel ?? 'App\Models\Word\KoWord'; 
        $this->wordPoolModel = $wordPoolModel ?? 'App\Models\Word\UserKoWordPool'; 
    }

    public function addWord(Request $request)
    {
        // return $this->success(['k' => '456','data' => $request->validate($this->validationRules())]);
        
        $data = $request->validate($this->validationRules());
        
        return response()->json(($this->wordModel)::create($data));
    }

    public function getLatestEntries(Request $request)
    {
        // 如果有传递 limit 参数，则使用传递的，没有的话默认300条
        $limit = (int) $request->query('limit', 300);

        // 获取最新的记录，按 _id
        $latestEntries = ($this->wordModel)::orderBy('_id', 'desc')
                                            ->limit($limit)
                                            ->get();

        return response()->json($latestEntries);
    }

    public function getTodayWords(Request $request)
    {
        $userId = Auth::id();
        $userWordPool = ($this->wordPoolModel)::where('user_id', $userId)->first();

        if (!$userWordPool) {
            return response()->json(['message' => 'Please initialize your word pool first.'], 400);
        }

        $currentDay = $userWordPool->current_day;
        $currentDayCount = $userWordPool->current_day_count;
        $wordChunks = $userWordPool->word_ids;
        $totalDays = count($wordChunks);

        if (!isset($wordChunks[$currentDay - 1])) {
            return $this->success($data = [],$message = '单词池数据已全部背诵', $code = 200);
        }

        $todayWordIds = $wordChunks[$currentDay - 1];
        $todayWords = ($this->wordModel)::whereIn('_id', $todayWordIds)->get();

        // 取出当前数据后 current_day + 1
        if ($currentDay + 1 <= $totalDays) {
            $userWordPool->current_day += 1;
            $userWordPool->save();
        }

        return $this->success([
            'day' => $currentDay,
            'day_count' => $currentDayCount,
            'words' => $todayWords,
        ]);
    }

    public function nextDay(Request $request)
    {
        $userId = Auth::id();
        $userWordPool = ($this->wordPoolModel)::where('user_id', $userId)->first();

        if (!$userWordPool) {
            return response()->json(['message' => 'Please initialize your word pool first.'], 400);
        }

        $currentDay = $userWordPool->current_day;
        $totalDays = count($userWordPool->word_ids);

        if ($currentDay >= $totalDays) {
            return response()->json(['message' => 'You have reached the last day.'], 200);
        }

        $userWordPool->current_day += 1;
        $userWordPool->save();

        $todayWordIds = $userWordPool->word_ids[$userWordPool->current_day - 1];
        $todayWords = ($this->wordModel)::whereIn('_id', $todayWordIds)->get();

        return $this->success([
            'day' => $userWordPool->current_day,
            'words' => $todayWords,
        ]);
    }

    protected function validationRules()
    {
        return [
            'word' => 'required|string',
            'romanization' => 'required|string',
            'meanings' => 'required|array',
            'meanings.*' => [
                'required',
                'array',
            ],
            'meanings.*.pos' => 'required|string',
            'meanings.*.origin' => 'nullable|string',
            'meanings.*.word_cn' => 'required|string',
            'meanings.*.definition_ko' => 'required|string',
            'meanings.*.definition_cn' => 'required|string',
            'meanings.*.example' => 'required|array',
            'meanings.*.example.*' => [
                'required',
                'array',
            ],
            'meanings.*.example.*.ko' => 'required|string',
            'meanings.*.example.*.cn' => 'required|string',
            'meanings.*.synonym' => 'nullable|array',
            'meanings.*.synonym.*' => 'string',
            'meanings.*.antonym' => 'nullable|array',
            'meanings.*.antonym.*' => 'string',
            'metadata' => 'required|array',
            'metadata.tags' => 'required|array',
            'metadata.tags.*' => 'string',
            'wordId' => 'required|string',
        ];

    }
}
