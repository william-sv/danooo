<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Word\WordController;
use App\Http\Controllers\Grammar\GrammarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', [AboutController::class, 'index']);

Route::post('register', [UserController::class, 'createUser']);

Route::middleware(['apiKeyAuth'])->prefix('word')->controller(WordController::class)->group(function(){
    Route::get('/latest', 'getLatestEntries');
    Route::get('/today', 'getTodayWords'); // 获取今天的单词池
    Route::get('/init', 'initializeWordPool'); // 初始化用户的单词池
    Route::get('/reset-word-pool', 'ResetWordPool'); // 重置用户的单词池
    Route::get('/reset-word-pool-current-day', 'ResetWordPoolCurrentDay'); // 重置用户的单词池进度
    Route::get('/next-day', 'nextDay');
    Route::post('/add', 'addWord');
});

Route::middleware(['apiKeyAuth'])->prefix('grammar')->controller(GrammarController::class)->group(function(){
    Route::get('/latest', 'getLatestEntries');
    Route::get('/today', 'getTodayGrammars'); // 获取今天的语法池
    Route::get('/init', 'initializeGrammarPool'); // 初始化用户的语法池
    Route::get('/reset-grammar-pool', 'ResetGrammarPool'); // 重置用户的语法池
    Route::get('/reset-grammar-pool-current-day', 'ResetGrammarPoolCurrentDay'); // 重置用户的语法进度
    Route::get('/next-day', 'nextDay');
    Route::post('/add', 'addGrammar'); // 如果需要添加语法条目
});

