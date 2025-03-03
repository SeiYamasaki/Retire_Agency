<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) { //->nullable();は空でも可能
            $table->id(); // 主キー (自動設定)
            $table->string('name'); // 必須
            $table->string('name_furigana'); // 必須
            $table->string('gender'); // 必須
            $table->date('birth_date'); // 必須
            $table->integer('age'); // 必須      
            $table->string('line_name'); // 必須
            $table->string('postal_code', 10); // 必須 (重複を許可)
            $table->string('prefecture'); // 必須
            $table->string('address'); // 必須 (重複を許可)
            $table->string('residence'); // 必須
            $table->string('contact_email')->unique(); // 必須かつ重複禁止
            $table->string('contact_phone')->unique(); // 必須かつ重複禁止

            // 勤務先情報
            $table->string('company_name'); // 必須
            $table->string('work_postal_code', 10); // 必須 (重複を許可)
            $table->string('work_prefecture'); // 必須
            $table->string('work_address'); // 必須 (重複を許可)
            $table->string('work_email')->unique(); // 必須かつ重複禁止
            $table->string('work_contact_phone')->nullable(); // 空でも良い
            $table->string('work_superior_phone')->unique(); // 必須かつ上司の携帯電話重複禁止

            // 雇用情報
            $table->string('employment_type'); // 必須
            $table->string('job_type'); // 必須
            $table->string('years_of_service'); // 必須
            $table->string('current_status'); // 必須
            $table->date('desired_resignation_date'); // 必須
            $table->date('final_work_date'); // 必須
            $table->string('paid_leave_preference'); // 必須
            $table->string('resignation_contact'); // 必須 (重複を許可)

            // 銀行口座情報
            $table->string('bank_name'); // 必須
            $table->string('account_type'); // 必須
            $table->string('account_number', 20)->index(); // 必須かつ索引 (検索速度向上)

            // 書類アップロード
            $table->json('employment_contract'); // 必須 (JSON カラム)
            $table->json('id_proof'); // 必須 (JSON カラム)

            // 認証情報
            $table->string('email')->unique(); // ユーザー認証用メール (重複禁止)
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
