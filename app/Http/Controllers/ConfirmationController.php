<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class ConfirmationController extends Controller
{
    public function show(Request $request)
    {
        // 各フォームのデータをセッションに保存
        session([
            'judgment' => $request->only([
                'conflict',
                'public_servant',
                'licensed_professional',
                'contractor',
                'foreign_trainee',
                'mental_illness',
                'trouble'
            ]),
            'form' => $request->only([
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
            ]),
            'consent' => $request->only(['consent'])
        ]);

        return view('confirmation', [
            'judgment' => session('judgment'),
            'form' => session('form'),
            'consent' => session('consent')
        ]);
    }
}
