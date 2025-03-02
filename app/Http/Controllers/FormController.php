<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\BankAccount;

class FormController extends Controller
{
    public function show()
    {
        return view('form');
    }

    public function submit(Request $request)
    {
        // **バリデーションを実行**
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_furigana' => 'required|string|max:255',
            'gender' => 'required|string|in:男性,女性',
            'birth_date' => 'required|date|before_or_equal:today',
            'age' => 'required|integer|min:0|max:150',
            'line_name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10|regex:/^\d{3}-\d{4}$/',
            'prefecture' => 'required|string|in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県',
            'address' => 'required|string|max:255',
            'residence' => 'required|string|in:実家,持家,社宅,社員寮,その他',
            'contact_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::check() ? Auth::id() : null),
            ],
            'contact_phone' => 'required|string|max:20|regex:/^0\d{1,4}-\d{1,4}-\d{4}$/',
            'company_name' => 'required|string|max:255',
            'work_postal_code' => 'required|string|max:10|regex:/^\d{3}-\d{4}$/',
            'work_prefecture' => 'required|string|in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県',
            'work_address' => 'required|string|max:255',
            'work_email' => 'required|email|max:255',
            'work_contact_phone' => 'nullable|string|max:20|regex:/^0\d{1,4}-\d{1,4}-\d{4}$/',
            'work_superior_phone' => 'required|string|max:20|regex:/^0\d{1,4}-\d{1,4}-\d{4}$/',
            'employment_type' => 'required|string|in:正社員,契約社員,派遣社員,準社員,アルバイト,社保パート,その他',
            'job_type' => 'required|string|in:飲食業,サービス業,販売業,建築業,運送業,不動産業,製造業,保険,金融,営業,教育関連,美容関連,医療関連,介護関連,事務関連,IT関連',
            'years_of_service' => 'required|string|in:6ヶ月未満,1年未満,2年未満,3年未満,10年未満,10年以上',
            'current_status' => 'required|string|in:公休,この後勤務,バックレ状態,勤務中',
            'desired_resignation_date' => 'required|date|after_or_equal:today',
            'final_work_date' => 'required|date|after_or_equal:today',
            'paid_leave_preference' => 'required|string|in:希望する,希望するが残日数が分からない,希望しない',
            'resignation_contact' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|string|in:普通口座,当座口座,貯蓄口座',
            'account_number' => 'required|string|digits_between:7,20',
            'employment_contract.*' => 'required|file|mimetypes:application/pdf,image/png,image/jpeg|max:5120',
            'id_proof.*' => 'required|file|mimetypes:application/pdf,image/png,image/jpeg|max:5120',

        ]);

        // **バリデーションエラー時**
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // **ファイルを storage/public に保存**
        $employmentContractPath = $request->file('employment_contract')->store('documents', 'public');
        $idProofPath = $request->file('id_proof')->store('documents', 'public');

        // **アップロード失敗時**
        if (!$employmentContractPath || !$idProofPath) {
            return redirect()->back()->withErrors(['file_upload' => 'ファイルのアップロードに失敗しました。']);
        }

        // **セッションにデータを保存**
        $formData = $request->except(['employment_contract', 'id_proof']);
        $formData['employment_contract_path'] = $employmentContractPath;
        $formData['id_proof_path'] = $idProofPath;

        session(['form' => $formData]);

        // **同意画面へリダイレクト**
        return redirect()->route('consent.show')->with('success', 'フォームが送信されました');
    }
}
