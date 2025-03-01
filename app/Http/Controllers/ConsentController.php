<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsentController extends Controller
{
    /**
     * 同意書の表示
     */
    public function show()
    {
        return view('consent');
    }

    /**
     * 同意書の送信処理
     */
    public function submit(Request $request)
    {

        // フォームのデータをバリデーション
        $request->validate([
            'consent' => 'required',
        ]);

        // 確認画面へリダイレクト（consent.confirm のビューに移動）
        return redirect()->route('consent.confirm')->with('success', '同意が完了しました');
    }

    /**
     * 確認画面の表示
     */
    public function confirm()
    {
        return view('confirmation');
    }
}
