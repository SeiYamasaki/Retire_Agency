<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RetireNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;
    public $pdfPath;

    /**
     * コンストラクタ
     */
    public function __construct($formData, $pdfPath)
    {
        $this->formData = $formData;
        $this->pdfPath = $pdfPath;
    }

    /**
     * メールの構築
     */
    public function build()
    {
        return $this->subject('【重要】退職通知のお知らせ')
                    ->view('emails.retire_notification') // 📩 送達文を本文にする
                    ->attach($this->pdfPath, [
                        'as' => '退職届.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
