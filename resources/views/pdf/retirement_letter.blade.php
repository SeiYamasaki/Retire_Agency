<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>退職届</title>
    <style>
        body {
            font-family: "ipaexg", sans-serif;
            font-size: 14px;
            line-height: 1.8;
        }

        .border {
            border: 1px solid black;
            padding: 20px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        h4 {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="border">
        <p>{{ now()->format('Y年m月d日') }}</p>
        <p>{{ session('form.company_name') }}</p>
        <p>{{ session('form.resignation_contact') }}様</p>

        <h4 class="title">退 職 届</h4>

        <p class="text-right">{{ session('form.prefecture') }}</p>
        <p class="text-right">{{ session('form.address') }}</p>
        <p class="text-right">{{ session('form.name') }}</p>

        <p>前略</p>
        <p>私、{{ session('form.name') }}
            は一身上の都合により、{{ \Carbon\Carbon::parse(session('form.desired_resignation_date'))->format('Y年m月d日') }}
            をもちまして退職いたしたく、ここに届出いたします。</p>
        <p>なお、「離職票」及び「給与所得者の源泉徴収票」並びに「社会保険資格喪失証明書」のご依頼をいたしますので、上記私の住所宛てにお手配のほどよろしくお願いいたします。</p>
        <p>併せて、未払給与がある場合になりますが､振込先は以下の通りですのでお振込の程よろしくお願い申し上げます。</p>
        <p>在職中は格別のご厚情を賜り、誠にありがとうございました。</p>
        <p>貴社のますますのご発展をお祈り申し上げます。</p>

        <p class="text-right font-weight-bold">草々</p>

        <p class="text-center font-weight-bold">記</p>
        <p class="text-center font-weight-bold">{{ session('form.bank_name') }}</p>
        <p class="text-center font-weight-bold">{{ session('form.account_type') }}</p>
        <p class="text-center font-weight-bold">{{ session('form.account_number') }}</p>
        <p class="text-center font-weight-bold">{{ session('form.account_holder') }}</p>
        <p class="text-center font-weight-bold">{{ session('form.name') }}</p>

        <p class="text-right font-weight-bold">以上</p>
    </div>
</body>

</html>
