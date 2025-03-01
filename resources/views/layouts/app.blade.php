<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '情報入力フォーム')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* 🌿 ページ背景 */
        body {
            background-color: #e6ffe6;
            /* 薄い緑 */
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* 📌 コンテンツエリア */
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            width: 100%;
        }

        /* 📌 ナビゲーションバーの中央寄せ */
        .navbar {
            width: 100%;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.6rem;
            text-align: center;
        }

        /* 📌 テーブルデザインの調整 */
        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        /* 📌 th, td の基本デザイン */
        .table-bordered th,
        .table-bordered td {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #bbb;
            /* 境界線を少し濃く */
            text-align: left;
            white-space: nowrap;
        }

        /* 📌 ホバー時の背景変更 */
        .table-bordered tbody tr:hover {
            background-color: #f1f8ff;
            transition: background-color 0.3s;
        }

        /* 📌 ボタンデザイン（PC & スマホ 共通） */
        .btn {
            font-size: 18px;
            font-weight: bold;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.4s ease-in-out;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin:2px;
        }

        /* 🌈 カラフルな修正ボタン */
        .btn-secondary {
            background: linear-gradient(45deg, #ff6b6b, #ffcc5c, #4ecdc4, #556270);
            background-size: 300% 300%;
            color: white;
            animation: gradientMove 6s infinite linear;
        }

        .btn-secondary:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            filter: brightness(1.1);
        }

        /* 💙 送信ボタン（目立たせる） */
        .btn-primary {
            background: linear-gradient(45deg, #ff3cac, #784ba0, #2b86c5);
            background-size: 300% 300%;
            color: white;
            animation: gradientMove 6s infinite linear;
        }

        .btn-primary:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            filter: brightness(1.2);
        }

        /* 🌈 グラデーションアニメーション */
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* 📌 スマホ対応（画面幅に収める & レスポンシブ調整） */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-bordered {
                width: 100%;
            }

            .table-bordered th,
            .table-bordered td {
                white-space: normal;
                word-wrap: break-word;
            }

            /* th, td を縦並びに */
            .table-bordered tbody tr {
                display: flex;
                flex-direction: column;
            }

            /* 📌 スマホ用のボタン調整（少し小さくする） */
            .btn {
                font-size: 16px;
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand mx-auto" href="#">退職代行モーアカン®</a>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
