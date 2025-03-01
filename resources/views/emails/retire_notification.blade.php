<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>退職通知</title>
</head>
<body>
    <p>{{ $formData['company_name'] }}</p>
    <p>{{ $formData['resignation_contact'] }} 様</p>

    <p>前略</p>
    
    <p>退職代行モーアカン®と申します。</p>
    <p>この度は、御社に勤務中の {{ $formData['name'] }} 様よりご依頼を受け、ご連絡を差し上げました。</p>
    <p>添付ファイルの退職届の通り、御社へ御伝達申し上げます。</p>
    
    <p>なお、今後の {{ $formData['name'] }} 様のご連絡につきましては、下記のポータルよりご連絡を承っておりますので、必要であればご利用ください。</p>
    <p>利用に関する情報につきましては、改めて別途ご案内申し上げます。</p>

    <p>【ポータルサイト】</p>
    <a href="http://localhost/login">http://localhost/login</a>

    <p>草々</p>
</body>
</html>
