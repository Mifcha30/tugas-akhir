<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;


Route::get('/', [TestController::class, 'index'])->name('test.index');
Route::get('/test/{type}/form', [TestController::class, 'userForm'])->name('test.form');
Route::post('/test/form', [TestController::class, 'storeUser'])->name('test.storeUser');
Route::get('/test/{type}/questions', [TestController::class, 'showQuestions'])->name('test.questions');
Route::post('/test/submit', [TestController::class, 'submitAnswers'])->name('test.submit');
Route::get('/test/result/{id}', [TestController::class, 'showResult'])->name('test.result');

