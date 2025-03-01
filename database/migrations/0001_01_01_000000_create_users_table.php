<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_furigana');
            $table->string('gender');
            $table->date('birth_date');
            $table->integer('age')->nullable();
            $table->string('line_name');
            $table->string('postal_code', 10);
            $table->string('prefecture');
            $table->string('address');
            $table->string('residence');
            $table->string('contact_email')->unique(); // ユーザーのメールアドレス (重複禁止)
            $table->string('contact_phone');

            // 勤務先情報
            $table->string('company_name')->nullable();
            $table->string('work_postal_code', 10)->nullable();
            $table->string('work_prefecture')->nullable();
            $table->string('work_address')->nullable();
            $table->string('work_email')->nullable();
            $table->string('work_contact_phone')->nullable();
            $table->string('work_superior_phone'); // 上司の携帯電話 (必須)

            // 雇用情報
            $table->string('employment_type');
            $table->string('job_type');
            $table->string('years_of_service');
            $table->string('current_status');
            $table->date('desired_resignation_date');
            $table->date('final_work_date');
            $table->string('paid_leave_preference');
            $table->string('resignation_contact')->nullable();

            // 銀行口座情報
            $table->string('bank_name');
            $table->string('account_type'); // 普通口座 / 当座口座 / 貯蓄口座
            $table->string('account_number', 20)->index(); // 一意ではなく索引を追加
            $table->string('account_holder');

            // 書類アップロード
            $table->string('employment_contract'); // 雇用契約書のパス
            $table->string('id_proof'); // 身分証明書のパス

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
