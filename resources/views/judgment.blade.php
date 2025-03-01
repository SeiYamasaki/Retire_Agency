@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">判定フォーム</h2>
        <form action="{{ route('judgment.submit') }}" method="POST">
            @csrf

            <style>
                .form-control {
                    border: 2px solid #000 !important;
                    width: 600px;
                    max-width: 100%;
                }

                .small-input {
                    width: 250px;
                }
            </style>

            <div class="mb-3">
                <label class="form-label">勤務先と揉めていますか？</label>
                <select class="form-control" name="conflict">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">公務員ですか？</label>
                <select class="form-control" name="public_servant">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">医師や弁護士などの資格保持者の勤務者ですか？</label>
                <select class="form-control" name="licensed_professional">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">業務委託者ですか？</label>
                <select class="form-control" name="contractor">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">外国人技能実習生ですか？</label>
                <select class="form-control" name="foreign_trainee">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">精神疾患がありますか？</label>
                <select class="form-control" name="mental_illness">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">残業代や退職金でトラブルがありますか？</label>
                <select class="form-control" name="trouble">
                    <option value="yes" selected>Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">判定する</button>
        </form>
    </div>
@endsection
