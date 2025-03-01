<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Judgment;

class JudgmentController extends Controller
{
    public function show()
    {
        return view('judgment'); // judgment.blade.php を表示
    }

    public function submit(Request $request)
    {
        $responses = $request->except('_token');

        // Yesが1つでもあれば、お引き受けできませんのページへ
        foreach ($responses as $key => $value) {
            if ($value === 'yes') {
                return redirect()->route('denied');
            }
        }

        // セッションにデータを保存
        session(['judgment' => $responses]);

        // データベースに保存
        Judgment::create($responses);

        return redirect()->route('form.show');
    }
}
