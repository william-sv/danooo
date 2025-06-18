<?php

namespace App\Http\Controllers\Grammar;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseGrammarController extends BaseController
{
    protected string $grammarModel;
    protected string $grammarPoolModel;

    public function __construct($grammarModel, $grammarPoolModel)
    {
        // 如果没有传递模型，提供默认值
        $this->grammarModel = $grammarModel ?? 'App\Models\Grammar\KoGrammar'; 
        $this->grammarPoolModel = $grammarPoolModel ?? 'App\Models\Grammar\UserKoGrammarPool'; 
    }

    public function addGrammar(Request $request)
    {
        $data = $request->validate($this->validationRules());
        
        return response()->success(($this->grammarModel)::create($data));
    }

    public function getLatestEntries(Request $request)
    {
        // 如果有传递 limit 参数，则使用传递的，没有的话默认300条
        $limit = (int) $request->query('limit', 300);

        // 获取最新的记录，按 _id
        $latestEntries = ($this->grammarModel)::orderBy('_id', 'desc')
                                            ->limit($limit)
                                            ->get();

        return response()->success($latestEntries);
    }

    public function getTodayGrammars(Request $request)
    {
        $userId = Auth::id();
        $userGrammarPool = ($this->grammarPoolModel)::where('user_id', $userId)->first();

        if (!$userGrammarPool) {
            return response()->error(['message' => 'Please initialize your grammar pool first.'], 400);
        }

        $currentDay = $userGrammarPool->current_day;
        $grammarChunks = $userGrammarPool->grammar_ids;
        $totalDays = count($grammarChunks);

        if (!isset($grammarChunks[$currentDay - 1])) {
            return response()->error(['message' => 'No more grammar points for today.'], 200);
        }

        $todayGrammarIds = $grammarChunks[$currentDay - 1];
        $todayGrammars = ($this->grammarModel)::whereIn('_id', $todayGrammarIds)->get();

        if ($currentDay + 1 <= $totalDays) {
            $userGrammarPool->current_day += 1;
            $userGrammarPool->save();
        }

        return $this->success([
            'day' => $currentDay,
            'day_count' => $totalDays,
            'grammars' => $todayGrammars,
        ]);
    }

    public function nextDay(Request $request)
    {
        $userId = Auth::id();
        $userGrammarPool = ($this->grammarPoolModel)::where('user_id', $userId)->first();

        if (!$userGrammarPool) {
            return response()->error(['message' => 'Please initialize your grammar pool first.'], 400);
        }

        $currentDay = $userGrammarPool->current_day;
        $totalDays = count($userGrammarPool->grammar_ids);

        if ($currentDay >= $totalDays) {
            return response()->error(['message' => 'You have reached the last day.'], 200);
        }

        $userGrammarPool->current_day += 1;
        $userGrammarPool->save();

        $todayGrammarIds = $userGrammarPool->grammar_ids[$userGrammarPool->current_day - 1];
        $todayGrammars = ($this->grammarModel)::whereIn('_id', $todayGrammarIds)->get();

        return $this->success([
            'day' => $userGrammarPool->current_day,
            'grammars' => $todayGrammars,
        ]);
    }


    
    protected function validationRules(): array
    {
        return [
            'version' => 'required|string',
            'grammarId' => 'required|string|unique:' . (new $this->grammarModel)->getTable() . ',grammarId',
            'grammarForm' => 'required|string',
            'appliesTo' => 'required|array|min:1',
            'description.shortChinese' => 'required|string',
            'description.shortKorean' => 'required|string',
            'conjugationRules' => 'required|array',
            'semanticFeatures' => 'required|array',
            'meaning' => 'required|array|min:1',
            'relatedGrammar' => 'nullable|array',
        ];
    }


}
