<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>退職届</title>
    <style>
        /* ✅ mPDF に適用可能なフォントを指定 */
        body {
            font-family: "ipaexg", sans-serif;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            font-family: "ipaexg", sans-serif;
            /* ✅ タイトルにフォントを明示的に指定 */
        }

        .content {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="title">退職届</div> <!-- ✅ タイトルにフォントが適用されるように修正 -->

    <p>日付: {{ now()->format('Y年m月d日') }}</p>
    <p>会社名: {{ $formData['company_name'] }}</p>
    <p>担当者様: {{ $formData['resignation_contact'] }}</p>

    <p>私、{{ $formData['name'] }} は、一身上の都合により、{{ $formData['desired_resignation_date'] }} をもちまして退職いたします。</p>

    <p>給与の振込先:</p>
    <ul>
        <li>銀行名: {{ $formData['bank_name'] ?? '未入力' }}</li>
        <li>口座種別: {{ $formData['account_type'] ?? '未入力' }}</li>
        <li>口座番号: {{ $formData['account_number'] ?? '未入力' }}</li>
        <li>口座名義: {{ $formData['account_holder'] ?? '未入力' }}</li>
    </ul>

    <p>以上</p>
</body>

</html>
