@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h2 class="text-danger">お引き受けできません</h2>
        <p>申し訳ございません。ご依頼をお引き受けすることができません。</p>
        <a href="{{ route('judgment.show') }}" class="btn btn-secondary">戻る</a>
    </div>
@endsection
