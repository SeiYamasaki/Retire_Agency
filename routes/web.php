<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\JudgmentController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ConsentController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\RetirementController;

// 判定フォーム
Route::get('/judgment', [JudgmentController::class, 'show'])->name('judgment.show');
Route::post('/judgment', [JudgmentController::class, 'submit'])->name('judgment.submit');

// 情報入力フォーム
Route::get('/form', [FormController::class, 'show'])->name('form.show');
Route::post('/form', [FormController::class, 'submit'])->name('form.submit');

// 同意フォーム
Route::get('/consent', [ConsentController::class, 'show'])->name('consent.show');
Route::post('/consent', [ConsentController::class, 'submit'])->name('consent.submit');
Route::get('/consent/confirm', [ConsentController::class, 'confirm'])->name('consent.confirm');

// 確認画面
Route::get('/confirmation', [ConfirmationController::class, 'show'])->name('confirmation.show');
Route::post('/confirmation', [ConfirmationController::class, 'submit'])->name('confirmation.submit');

//サンキューページ
Route::get('/thank-you', function () {
    return view('thank_you');
})->name('thank_you');


// 退職通知の送信
Route::post('/confirmation/submitFinal', [RetirementController::class, 'submitFinal'])->name('confirmation.submitFinal');


// 拒否ページ
Route::get('/denied', function () {
    return view('denied');
})->name('denied');
