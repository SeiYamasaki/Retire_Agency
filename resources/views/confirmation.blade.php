@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered">
            @foreach (session('form', []) as $key => $value)
                @php
                    // 非表示にする項目
                    $hiddenKeys = ['email', 'password', 'employment_contract_paths', 'id_proof_paths'];

                    // 画像ファイルの判定
                    $isImage = in_array($key, ['employment_contract', 'id_proof']);

                    // 配列データを適切に処理（配列なら最初の要素を取得）
                    if (is_array($value)) {
                        $formattedValue = trim($value[0], '[]"'); // 配列なら1つ目を取得し、不要な `[" "]` を除去
                    } else {
                        $formattedValue = trim($value, '[]"'); // 文字列でも不要な `[" "]` を除去
                    }

                    // 画像のファイルパスを取得
                    if ($isImage && is_string($formattedValue)) {
                        $imagePath = 'storage/documents/' . basename($formattedValue);
                    } else {
                        $imagePath = null;
                    }

                    // 画像URL
                    $imageUrl = url($imagePath);
                @endphp

                @if (!in_array($key, $hiddenKeys))
                    <tr>
                        <th>{{ __('labels.' . $key) }}</th>
                        <td>
                            @if ($isImage && $imagePath)
                                <p>画像URL:
                                    <a href="{{ $imageUrl }}" target="_blank">{{ $imageUrl }}</a>
                                </p>
                                <img src="{{ $imageUrl }}" alt="添付画像" style="max-width: 200px; height: auto;">
                            @else
                                {{ $formattedValue }}
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    <<h3 class="text-warning">同意フォーム</h3>
        <p>個人情報取扱いの同意及び合意:
            <strong>{{ session('consent.consent', 0) == 1 ? '同意及び合意済み' : '未同意及び未合意' }}</strong>
        </p>

        {{-- 送達文 --}}
        <h3 class="text-info mt-5">送達文編</h3>
        <div class="border p-3">
            <p>{{ session('form.company_name', '会社名未入力') }}</p>
            <p>{{ session('form.resignation_contact', '担当者未入力') }}様</p>
            <p>前略</p>
            <br>
            <p>退職代行モーアカン®と申します｡</p>
            <p>この度は，御社に勤務中の{{ session('form.name', '氏名未入力') }}様よりご依頼を受けてご連絡を差し上げました｡</p>
            <p>添付ファイルの退職届の通り御社へ御伝達申し上げます｡</p>
            <p>なお，今後の{{ session('form.name') }}様のご連絡につきましては，下記のポータルよりご連絡を承っておりますので，必要であればご利用ください｡</p>
            <p>利用に関する情報につきましては､改めて別途ご案内申し上げます｡</p>
            <p class="text-right font-weight-bold">草々</p>
            <p class="text-center font-weight-bold">記</p>
            <div style="text-align: center; margin: 20px 0;">
                <a href="http://localhost/login"
                    style="font-size: 20px; text-decoration: none; color: blue; display: block; margin-bottom: 20px;">
                    http://localhost/login
                </a>
                <img src="{{ asset('images/login.png') }}" alt="中央配置の画像" style="width: 300px; height: auto;">
            </div>
            <p>以上</p>
        </div>

        {{-- 退職届 --}}
        <h3 class="text-danger mt-5">退職届編</h3>
        <div class="border p-3">
            <p>{{ now()->format('Y年m月d日') }}</p>
            <p>{{ session('form.company_name', '会社名未入力') }}</p>
            <p>{{ session('form.resignation_contact', '担当者未入力') }}様</p>
            <br>
            <h4 class="text-center">退 職 届</h4>
            <p class="text-right" style="text-align: right;">{{ session('form.prefecture', '都道府県未入力') }}</p>
            <p class="text-right" style="text-align: right;">{{ session('form.address', '住所未入力') }}</p>
            <p class="text-right" style="text-align: right;">{{ session('form.name', '氏名未入力') }}</p>

            <br>

            <p>前略</p>
            <p>私、{{ session('form.name') }}は一身上の都合により、{{ \Carbon\Carbon::parse(session('form.desired_resignation_date', '退職日未入力'))->format('Y年m月d日') }}をもちまして退職いたしたく、ここに届出いたします｡
            </p>
            </p>
            <p>なお､「離職票」及び「給与所得者の源泉徴収票」並びに「社会保険資格喪失証明書」のご依頼をいたしますので､上記住所宛てにお手配のほどよろしくお願いいたします｡</p>
            <p>併せて､給与のお振込先は以下の通りですのでお振込の程よろしくお願い申し上げます｡</p>
            <p>在職中は格別のご厚情を賜り、誠にありがとうございました。</p>
            <p>貴社のますますのご発展をお祈り申し上げます。</p>

            <p class="text-right font-weight-bold">草々</p>
            <p class="text-center font-weight-bold">記</p>
            <p class="text-center font-weight-bold">{{ session('form.bank_name', '銀行名未入力') }}</p>
            <p class="text-center font-weight-bold">{{ session('form.account_type', '口座種別未入力') }}</p>
            <p class="text-center font-weight-bold">{{ session('form.account_number', '口座番号未入力') }}</p>

            <p class="text-right font-weight-bold">以上</p>
        </div>

        </div>

        <form action="{{ route('confirmation.submitFinal') }}" method="POST">
            @csrf
            <div class="text-center mt-4">
                <a href="{{ route('judgment.show') }}" class="btn btn-secondary">判定フォームを修正</a>
                <a href="{{ route('form.show') }}" class="btn btn-secondary">情報入力を修正</a>
                <a href="{{ route('consent.show') }}" class="btn btn-secondary">同意内容を修正</a>
                <button type="submit" class="btn btn-primary">送信</button>
            </div>
        </form>
    @endsection
