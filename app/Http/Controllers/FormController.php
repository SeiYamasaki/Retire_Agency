<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class FormController extends Controller
{
    public function show()
    {
        return view('form');
    }

    public function submit(Request $request)
    {
        // **フォームのデータを確認**
        Log::info('フォームデータ受信:', $request->all());
        // dd($request->all()); // ← これを有効化するとデータが画面に表示される

        // **バリデーションを実行**
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_furigana' => 'required|string|max:255',
            'gender' => 'required|string|in:男性,女性',
            'birth_date' => 'required|date|before_or_equal:today',
            'age' => 'required|integer|min:0|max:150',
            'line_name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10|regex:/^\d{3}-\d{4}$/',
            'prefecture' => 'required|string',
            'address' => 'required|string|max:255',
            'residence' => 'required|string',
            'contact_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'contact_email')->ignore(Auth::check() ? Auth::id() : null),
            ],
            'contact_phone' => 'required|string|max:20|regex:/^0\d{1,4}-\d{1,4}-\d{4}$/',
            'company_name' => 'required|string|max:255',
            'work_postal_code' => 'required|string|max:10|regex:/^\d{3}-\d{4}$/',
            'work_prefecture' => 'required|string',
            'work_address' => 'required|string|max:255',
            'work_email' => 'required|email|max:255',
            'work_contact_phone' => 'nullable|string|max:20',
            'work_superior_phone' => 'required|string|max:20',
            'employment_type' => 'required|string',
            'job_type' => 'required|string',
            'years_of_service' => 'required|string',
            'current_status' => 'required|string',
            'desired_resignation_date' => 'required|date|after_or_equal:today',
            'final_work_date' => 'required|date|after_or_equal:today',
            'paid_leave_preference' => 'required|string',
            'resignation_contact' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|string',
            'account_number' => 'required|string|digits_between:7,20',
            'employment_contract' => 'nullable|array', // JSON 保存のため修正
            'employment_contract.*' => 'file|mimetypes:application/pdf,image/png,image/jpeg|max:5120',
            'id_proof' => 'nullable|array', // JSON 保存のため修正
            'id_proof.*' => 'file|mimetypes:application/pdf,image/png,image/jpeg|max:5120',
        ]);

        // **バリデーションエラー時**
        if ($validator->fails()) {
            Log::error('バリデーションエラー:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator) //エラーメッセージを残す
                ->withInput(); //バリデーションエラーがあった場合のみ、入力値を一時的に保持
        }

        // **バリデーション済みデータを取得**
        $validatedData = $validator->validated();

        // **`email` に `contact_email` をコピー**
        $validatedData['email'] = $validatedData['contact_email'];
        // **デフォルトのパスワードを設定**
        $validatedData['password'] = bcrypt('defaultpassword'); // この方法だと、パスワードなしでも登録可能になる！しかし、パスワードが空だとログインできなくなるので注意！


        // **ファイルを storage/public に保存**
        $employmentContractPaths = [];
        if ($request->hasFile('employment_contract')) {
            foreach ($request->file('employment_contract') as $file) {
                $path = $file->store('documents', 'public');
                $employmentContractPaths[] = asset("storage/{$path}");
            }
        }

        $idProofPaths = [];
        if ($request->hasFile('id_proof')) {
            foreach ($request->file('id_proof') as $file) {
                $path = $file->store('documents', 'public');
                $idProofPaths[] = asset("storage/{$path}");
            }
        }

        // **アップロード失敗時 (アップロードがある場合のみチェック)**
        if ($request->hasFile('employment_contract') && empty($employmentContractPaths)) {
            Log::error('雇用契約書のアップロード失敗');
            return redirect()->back()->withErrors(['employment_contract' => '雇用契約書のアップロードに失敗しました。']);
        }

        if ($request->hasFile('id_proof') && empty($idProofPaths)) {
            Log::error('身分証明書のアップロード失敗');
            return redirect()->back()->withErrors(['id_proof' => '身分証明書のアップロードに失敗しました。']);
        }

        // **配列をそのまま `$validatedData` に追加**
        $validatedData['employment_contract'] = json_encode($employmentContractPaths);
        $validatedData['id_proof'] = json_encode($idProofPaths);

        // **セッションにフォームデータ全体を保存（修正）**
        session([
            'form' => array_merge($validatedData, [
                'employment_contract_paths' => $employmentContractPaths,
                'id_proof_paths' => $idProofPaths
            ])
        ]);

        // **データベースに登録**
        try {
            Log::info('登録データ:', $validatedData);
            $user = User::create($validatedData);
            Log::info('ユーザー登録成功:', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('データベース登録エラー:', [
                'error' => $e->getMessage(),
                'input_data' => $validatedData
            ]);
            return redirect()->back()->withErrors(['database_error' => 'データの保存に失敗しました。']);
        }

        // **成功メッセージを付けてリダイレクト**
        return redirect()->route('consent.show')->with('success', 'フォームが送信されました');
    }
}
