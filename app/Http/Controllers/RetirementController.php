<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\RetireNotificationMail;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;

class RetirementController extends Controller
{
    /**
     * 退職通知メールを送信する（送達文を本文に、退職届をPDF添付）
     */
    public function submitFinal(Request $request)
    {
        Log::info('✅ submitFinal メソッドが実行されました');

        // ✅ **セッションデータを次のリクエストでも維持**
        session()->reflash();

        try {
            // ✅ **セッションデータを取得**
            $formData = session()->all();
            Log::info('📌 セッションデータ:', $formData);

            if (!isset($formData['form']) || !isset($formData['form']['work_email'])) {
                Log::error('❌ 送信に必要なデータが不足しています');
                return redirect()->route('confirmation.show')->with('error', '送信に必要なデータが不足しています。');
            }

            $recipientEmail = $formData['form']['work_email'];

            // ✅ **PDF 保存用のディレクトリを確認し、なければ作成**
            $pdfDir = storage_path('app/pdfs');
            if (!file_exists($pdfDir)) {
                mkdir($pdfDir, 0775, true);
                Log::info('📂 PDFフォルダを作成しました: ' . $pdfDir);
            }

            // ✅ **mPDF の一時フォルダを変更**
            $pdfPath = $pdfDir . '/retirement_notice_' . time() . '.pdf';
            Log::info("✅ PDF パス: " . $pdfPath);

            // ✅ **mPDF インスタンス作成（日本語フォント設定）**
            $mpdf = new Mpdf([
                'tempDir'    => storage_path('app/mpdf'), // 一時フォルダを指定
                'mode'       => 'ja', // 日本語モード
                'format'     => 'A4',
                'default_font' => 'ipaexg', // デフォルトの日本語フォント
                'fontDir'    => array_merge(
                    (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'],
                    [storage_path('fonts')]
                ),
                'fontdata'   => (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'] + [
                    'ipaexg' => ['R' => 'ipaexg.ttf', 'B' => 'ipaexg.ttf'], // IPAexゴシック
                    'ipaexm' => ['R' => 'ipaexm.ttf', 'B' => 'ipaexm.ttf']  // IPAex明朝
                ],
            ]);

            // ✅ **日本語フォントを明示的にセット**フォントを明朝 mpdf->SetFont('ipaexm');

            $mpdf->SetFont('ipaexg');

            // ✅ **ビューのデータを安全に取得**
            $pdfData = [
                'company_name'       => $formData['form']['company_name'] ?? '未入力',
                'resignation_contact' => $formData['form']['resignation_contact'] ?? '未入力',
                'name'               => $formData['form']['name'] ?? '未入力',
                'desired_resignation_date' => $formData['form']['desired_resignation_date'] ?? '未入力',
                'bank_name'          => $formData['form']['bank_name'] ?? '未入力',
                'account_type'       => $formData['form']['account_type'] ?? '未入力',
                'account_number'     => $formData['form']['account_number'] ?? '未入力',
                'account_holder'     => $formData['form']['account_holder'] ?? '未入力',
            ];

            // ✅ **CSS を適用し、フォントを明示的に設定**
            $css = '<style>
                body { font-family: ipaexg; }
                p, h1, h2, h3, h4, h5, h6, ul, li { font-family: ipaexg; }
            </style>';

            // ✅ **HTML を UTF-8 に変換**
            $html = $css . view('pdf.retirement_letter', ['formData' => $pdfData])->render();
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

            // ✅ **PDF 作成**
            $mpdf->WriteHTML($html);
            $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

            // ✅ **PDF ファイルが作成されたか確認**
            if (!file_exists($pdfPath)) {
                Log::error("❌ PDF が生成されませんでした: " . $pdfPath);
                return redirect()->route('thank_you')->with('error', 'PDF の生成に失敗しました。');
            }

            Log::info('✅ PDF 生成成功');

            // ✉ **2. メール送信**
            try {
                Mail::to($recipientEmail)->send(new RetireNotificationMail($pdfData, $pdfPath));
                Log::info('✅ メール送信成功');
            } catch (\Exception $e) {
                Log::error('❌ メール送信エラー: ' . $e->getMessage());
                return redirect()->route('thank_you')->with('error', 'メール送信に失敗しました。');
            }

            return redirect()->route('thank_you')->with('success', '退職通知を送信しました！');

        } catch (\Exception $e) {
            Log::error('❌ 退職通知メール送信エラー: ' . $e->getMessage());
            return redirect()->route('thank_you')->with('error', 'メール送信に失敗しました。');
        }
    }
}
