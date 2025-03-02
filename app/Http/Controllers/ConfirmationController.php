<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfirmationController extends Controller
{
    /**
     * 確認画面の表示
     */
    public function show(Request $request)
    {
        // 各フォームのデータを取得し、セッションに保存
        session([
            'judgment' => array_filter($request->only([
                'conflict',
                'public_servant',
                'licensed_professional',
                'contractor',
                'foreign_trainee',
                'mental_illness',
                'trouble'
            ])),

            'form' => array_filter($request->only([
                'name',
                'name_furigana',
                'gender',
                'birth_date',
                'age',
                'line_name',
                'postal_code',
                'prefecture',
                'address',
                'residence',
                'contact_email',
                'contact_phone',
                'current_status',
                'desired_resignation_date',
                'final_work_date',
                'paid_leave_preference',
                'company_name',
                'work_postal_code',
                'work_prefecture',
                'work_address',
                'work_email',
                'work_contact_phone',
                'work_superior_phone',
                'employment_type',
                'job_type',
                'years_of_service',
                'bank_name',
                'account_type',
                'account_number',
                'resignation_contact'
            ])),

            'consent' => array_filter($request->only(['consent']))
        ]);

        // セッションデータを取得（デフォルト値は空配列）
        $judgment = session('judgment', []);
        $form = session('form', []);
        $consent = session('consent', []);

        // 確認画面のビューを表示
        return view('confirmation', compact('judgment', 'form', 'consent'));
    }
}
