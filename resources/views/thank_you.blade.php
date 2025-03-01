@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h2 class="mt-5">ご利用ありがとうございました</h2>
        <p>退職通知の送信が完了しました。</p>
        <a href="{{ route('thank_you') }}" class="btn btn-primary mt-3">ホームへ戻る</a>
    </div>
@endsection
