@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">情報入力</h2>
        <!-- バリデーションエラー表示 -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('form.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <style>
                body {
                    background-color: #e6ffe6;
                    /* 薄い緑色 */
                    display: flex;
                    justify-content: center;
                    /* 水平方向の中央揃え */
                    align-items: center;
                    /* 垂直方向の中央揃え */
                    min-height: 100vh;
                    /* 画面の高さいっぱいに表示 */
                    margin: 0;
                }

                .form-control {
                    border: 2px solid #000 !important;
                    width: 600px;
                    max-width: 100%;
                }

                .small-input {
                    width: 200px;
                }

                .file-input {
                    width: 450px;
                }

                h4 {
                    margin-top: 20px;
                    padding: 5px;
                    font-weight: bold;
                }

                .section-personal {
                    color: blue;
                }

                .section-contact {
                    color: green;
                }

                .section-work {
                    color: orange;
                }

                .section-resignation {
                    color: red;
                }

                .section-file {
                    color: purple;
                }

                /* カメラプレビュー用 */
                .camera-container {
                    display: flex;
                    flex-direction: column;
                    /* ボタンとカメラの配置を統一 */
                    align-items: flex-start;
                    margin-top: 10px;
                }

                img {
                    display: block;
                    margin-top: 10px;
                }

                video {
                    width: 100%;
                    max-width: 300px;
                    /* 撮影画面を適切なサイズに */
                }
            </style>

            <h4 class="section-personal">あなたの情報 ※必須</h4>
            <div class="mb-3">
                <label for="name" class="form-label">あなたの名前 ※必須</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="name_furigana" class="form-label">あなたのお名前のフリガナ ※必須</label>
                <input type="text" class="form-control" id="name_furigana" name="name_furigana" required>
            </div>
            <div class="mb-3">
                <label class="form-label">あなたの性別 ※必須</label><br>
                <input type="radio" id="male" name="gender" value="男性" required>
                <label for="male">男性</label>
                <input type="radio" id="female" name="gender" value="女性">
                <label for="female">女性</label>
            </div>
            <!-- 生年月日 -->
            <div class="mb-3">
                <label for="birth_date" class="form-label">あなたの生年月日 ※必須</label>
                <input type="date" class="form-control small-input" id="birth_date" name="birth_date" required
                    onchange="calculateAge()">
            </div>
            <!-- 満年齢 -->
            <div class="mb-3">
                <label for="age" class="form-label">あなたの満年齢 ※必須</label>
                <input type="text" class="form-control small-input" id="age" name="age" readonly>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // 🎂 生年月日を選択すると満年齢を自動計算
                    function calculateAge() {
                        const birthDateInput = document.getElementById('birth_date');
                        const ageInput = document.getElementById('age');

                        if (birthDateInput.value) {
                            const birthDate = new Date(birthDateInput.value);
                            const today = new Date();
                            let age = today.getFullYear() - birthDate.getFullYear();
                            const monthDiff = today.getMonth() - birthDate.getMonth();
                            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                                age--;
                            }
                            ageInput.value = age; // 満年齢を入力欄にセット
                        }
                    }

                    // `onchange` で実行されない可能性があるのでイベントリスナーを追加
                    document.getElementById('birth_date').addEventListener('change', calculateAge);
                });
            </script>
            <div class="mb-3">
                <label for="line_name" class="form-label">あなたのLINE登録名 ※LINEに登録されている表示名 ※必須</label>
                <input type="text" class="form-control" id="line_name" name="line_name" required>
            </div>
            <div class="mb-3">
                <label for="postal_code" class="form-label">あなたの住所の郵便番号 ※必須 例:◯◯◯ー◯◯◯◯</label>
                <input type="text" class="form-control small-input" id="postal_code" name="postal_code" required>
            </div>
            <div class="mb-3">
                <label for="prefecture" class="form-label">あなたの住所の都道府県 ※必須</label>
                <select class="form-control small-input" id="prefecture" name="prefecture" required>
                    <option value="">選択してください</option>
                    @foreach (['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'] as $prefecture)
                        <option value="{{ $prefecture }}">{{ $prefecture }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">あなたの住所(都道府県を除く住所) ※必須</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <!-- 住居 -->
            <div class="mb-3">
                <label for="residence" class="form-label">あなたの住居の形態 ※必須</label>
                <select class="form-control" id="residence" name="residence" required>
                    <option value="">選択してください</option>
                    <option value="実家">実家</option>
                    <option value="持家">持家</option>
                    <option value="社宅">社宅</option>
                    <option value="社員寮">社員寮</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="contact_email" class="form-label">あなたの連絡先メールアドレス ※退職代行モーアカン®から連絡を希望するアドレス ※必須</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" required>
            </div>
            <div class="mb-3">
                <label for="contact_phone" class="form-label">あなたの連絡先電話番号 ※必須 例:090-◯◯◯◯-◯◯◯◯</label>
                <input type="tel" class="form-control small-input" id="contact_phone" name="contact_phone" required>
            </div>
            <!-- 現在の状況 -->
            <div class="mb-3">
                <label for="current_status" class="form-label">現在の状況 ※必須</label>
                <select class="form-control" id="current_status" name="current_status" required>
                    <option value="">選択してください</option>
                    <option value="公休">公休</option>
                    <option value="この後勤務">この後勤務</option>
                    <option value="バックレ状態">バックレ</option>
                    <option value="勤務中">勤務中</option>
                </select>
            </div>
            <!-- 希望退職日 -->
            <div class="mb-3">
                <label for="desired_resignation_date" class="form-label">希望退職日 ※退職届書に記載する退職日になります｡ ※必須</label>
                <input type="date" class="form-control small-input" id="desired_resignation_date"
                    name="desired_resignation_date" required>
            </div>
            <!-- 最終出勤日 -->
            <div class="mb-3">
                <label for="final_work_date" class="form-label">最終出勤日 ※必須</label>
                <input type="date" class="form-control small-input" id="final_work_date" name="final_work_date"
                    required>
            </div>
            <!-- 有給取得希望 -->
            <div class="mb-3">
                <label for="paid_leave_preference" class="form-label">有給取得希望 ※有給取得できない場合があります｡ ※必須</label>
                <select class="form-control" id="paid_leave_preference" name="paid_leave_preference" required>
                    <option value="">選択してください</option>
                    <option value="希望する">希望する</option>
                    <option value="希望するが残日数が分からない">希望するが残日数が分からない</option>
                    <option value="希望しない">希望しない</option>
                </select>
            </div>

            <h4 class="section-work">あなたの勤務先情報</h4>
            <div class="mb-3">
                <label for="company_name" class="form-label">あなたの勤務先法人名 正式な法人名を入力してください｡ ※必須 例 : 株式会社◯◯◯◯</label>
                <input type="text" class="form-control" id="company_name" name="company_name">
            </div>
            <div class="mb-3">
                <label for="work_postal_code" class="form-label">あなたの勤務先の住所の郵便番号 ※必須 例:◯◯◯ー◯◯◯◯</label>
                <input type="text" class="form-control small-input" id="work_postal_code" name="work_postal_code">
            </div>
            <div class="mb-3">
                <label for="work_prefecture" class="form-label">あなたの勤務先の住所の都道府県 ※必須</label>
                <select class="form-control small-input" id="work_prefecture" name="work_prefecture">
                    <option value="">選択してください</option>
                    @foreach (['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'] as $prefecture)
                        <option value="{{ $prefecture }}">{{ $prefecture }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="work_address" class="form-label">あなたの勤務先の住所(都道府県を除く) ※必須</label>
                <input type="text" class="form-control" id="work_address" name="work_address">
            </div>
            <div class="mb-3">
                <label for="work_email" class="form-label">あなたの勤務先のメールアドレス ※退職を伝える方(あなたのアドレスではない)のアドレスを正確に記入ください！
                    ※必須</label>
                <input type="text" class="form-control" id="work_email" name="work_email">
            </div>
            <div class="mb-3">
                <label for="work_contact_phone" class="form-label">あなたの勤務先の電話番号 (代表電話) ※必須</label>
                <input type="text" class="form-control" id="work_contact_phone" name="work_contact_phone">
            </div>
            <div class="mb-3">
                <label for="work_superior_phone" class="form-label">あなたの勤務先の上司の携帯番号 (携帯電話) ※必須</label>
                <input type="text" class="form-control" id="work_superior_phone" name="work_superior_phone">
            </div>

            <!-- 雇用形態 -->
            <div class="mb-3">
                <label for="employment_type" class="form-label">あなたの雇用形態 ※必須</label>
                <select class="form-control" id="employment_type" name="employment_type" required>
                    <option value="">選択してください</option>
                    <option value="正社員">正社員</option>
                    <option value="契約社員">契約社員</option>
                    <option value="派遣社員">派遣社員</option>
                    <option value="準社員">準社員</option>
                    <option value="アルバイト">アルバイト</option>
                    <option value="社保パート">社保パート</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <!-- 職種 -->
            <div class="mb-3">
                <label for="job_type" class="form-label">あなたの職種 ※必須</label>
                <select class="form-control" id="job_type" name="job_type" required>
                    <option value="">選択してください</option>
                    @foreach (['飲食業', 'サービス業', '販売業', '建築業', '運送業', '不動産業', '製造業', '保険', '金融', '営業', '教育関連', '美容関連', '医療関連', '介護関連', '事務関連', 'IT関連'] as $job)
                        <option value="{{ $job }}">{{ $job }}</option>
                    @endforeach
                </select>
            </div>
            <!-- 勤続年数 -->
            <div class="mb-3">
                <label for="years_of_service" class="form-label">勤続年数 ※必須</label>
                <select class="form-control" id="years_of_service" name="years_of_service" required>
                    <option value="">選択してください</option>
                    <option value="6ヶ月未満">6ヶ月未満</option>
                    <option value="1年未満">1年未満</option>
                    <option value="2年未満">2年未満</option>
                    <option value="3年未満">3年未満</option>
                    <option value="10年未満">10年未満</option>
                    <option value="10年以上">10年以上</option>
                </select>
            </div>
            <h4 class="section-resignation">退職関連</h4>
            <div class="mb-3">
                <label for="bank_name" class="form-label">給与振込口座銀行名と支店名 例:◯◯◯◯銀行◯◯支店 ※必須</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name">
            </div>

            <div class="mb-3">
                <label for="account_type" class="form-label">給与振込口座の種類 例:普通口座 ※必須</label>
                <input type="text" class="form-control" id="account_type" name="account_type">
            </div>

            <div class="mb-3">
                <label for="account_number" class="form-label">給与振込口座番号 例:12345678 ※必須</label>
                <input type="text" class="form-control" id="account_number" name="account_number">
            </div>

            <div class="mb-3">
                <label for="resignation_contact" class="form-label">退職を伝えるべき勤務先の人の名前 (上司のフルネーム又は代表取締役のフルネーム)※必須</label>
                <input type="text" class="form-control" id="resignation_contact" name="resignation_contact">
            </div>

            <h4 class="section-file">ファイルアップロード</h4>

            <!-- 雇用契約書 -->
            <div class="mb-3">
                <label for="employment_contract" class="form-label">
                    あなたの雇用契約書または労働条件通知書（撮影可）※必須
                </label>

                <!-- ファイル選択 (複数ファイル対応) -->
                <input type="file" class="form-control file-input" id="employment_contract"
                    name="employment_contract[]" accept="image/*" multiple
                    onchange="previewFiles(event, 'preview_employment_contract', 'reset_employment_contract')">

                <!-- カメラを起動するボタン -->
                <button type="button" class="btn btn-secondary mt-2" id="start_employment_contract"
                    onclick="startCamera('employment_contract')">📷 カメラを起動</button>

                <!-- カメラ表示 -->
                <div class="camera-container" id="cameraContainer_employment_contract" style="display: none;">
                    <video id="cameraView_employment_contract" autoplay playsinline></video>
                </div>

                <!-- 撮影ボタン -->
                <button type="button" class="btn btn-primary mt-2" id="capture_employment_contract"
                    style="display:none;" onclick="captureImage('employment_contract')">📸 撮影</button>

                <!-- プレビューエリア（複数画像対応） -->
                <div id="preview_employment_contract" class="preview-container"
                    style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>

                <!-- やり直すボタン -->
                <button type="button" class="btn btn-danger mt-2 reset-btn" id="reset_employment_contract"
                    style="display:none;" onclick="resetImages('employment_contract')">🔄 やり直す</button>
            </div>

            <!-- 身分証明書 -->
            <div class="mb-3">
                <label for="id_proof" class="form-label">
                    あなたの身分証明書（撮影可）※必須
                </label>

                <!-- ファイル選択 (複数ファイル対応) -->
                <input type="file" class="form-control file-input" id="id_proof" name="id_proof[]" accept="image/*"
                    multiple onchange="previewFiles(event, 'preview_id_proof', 'reset_id_proof')">

                <!-- カメラを起動するボタン -->
                <button type="button" class="btn btn-secondary mt-2" id="start_id_proof"
                    onclick="startCamera('id_proof')">📷 カメラを起動</button>

                <!-- カメラ表示 -->
                <div class="camera-container" id="cameraContainer_id_proof" style="display: none;">
                    <video id="cameraView_id_proof" autoplay playsinline></video>
                </div>

                <!-- 撮影ボタン -->
                <button type="button" class="btn btn-primary mt-2" id="capture_id_proof" style="display:none;"
                    onclick="captureImage('id_proof')">📸 撮影</button>

                <!-- プレビューエリア（複数画像対応） -->
                <div id="preview_id_proof" class="preview-container"
                    style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>

                <!-- やり直すボタン -->
                <button type="button" class="btn btn-danger mt-2 reset-btn" id="reset_id_proof" style="display:none;"
                    onclick="resetImages('id_proof')">🔄 やり直す</button>
            </div>

            <script>
                let videoStream = null;

                // 📂 選択した画像をプレビュー（過去の画像を保持）
                function previewFiles(event, previewId, resetId) {
                    const input = event.target;
                    const previewContainer = document.getElementById(previewId);
                    const resetButton = document.getElementById(resetId);
                    const dataTransfer = new DataTransfer();

                    // **既存の `input.files` の内容を保持**
                    for (let i = 0; i < input.files.length; i++) {
                        dataTransfer.items.add(input.files[i]);
                    }

                    // **新しく選択した画像をプレビューに追加**
                    Array.from(input.files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                let img = document.createElement('img');
                                img.src = e.target.result;
                                img.classList.add("preview-img"); // CSS で統一
                                previewContainer.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // **`input.files` を確実に更新**
                    input.files = dataTransfer.files;

                    // **画像が追加されたら「やり直す」ボタンを表示**
                    resetButton.style.display = "block";
                }

                // 📷 カメラを起動
                function startCamera(target) {
                    if (videoStream) stopCamera();

                    const cameraView = document.getElementById(`cameraView_${target}`);
                    const cameraContainer = document.getElementById(`cameraContainer_${target}`);
                    const captureButton = document.getElementById(`capture_${target}`);

                    navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: "environment"
                            }
                        })
                        .then(function(stream) {
                            videoStream = stream;
                            cameraView.srcObject = stream;
                            cameraContainer.style.display = "block";
                            captureButton.style.display = "block";
                        })
                        .catch(function(error) {
                            alert("カメラの起動に失敗しました: " + error);
                        });
                }

                // 📸 撮影後にプレビュー表示（過去の画像を保持）
                function captureImage(target) {
                    const cameraView = document.getElementById(`cameraView_${target}`);
                    const canvas = document.createElement('canvas');
                    const previewContainer = document.getElementById(`preview_${target}`);
                    const fileInput = document.getElementById(target);
                    const resetButton = document.getElementById(`reset_${target}`);
                    const captureButton = document.getElementById(`capture_${target}`);
                    const dataTransfer = new DataTransfer();

                    // **既存の `input.files` を保持**
                    for (let i = 0; i < fileInput.files.length; i++) {
                        dataTransfer.items.add(fileInput.files[i]);
                    }

                    canvas.width = cameraView.videoWidth;
                    canvas.height = cameraView.videoHeight;
                    canvas.getContext('2d').drawImage(cameraView, 0, 0, canvas.width, canvas.height);

                    let img = document.createElement('img');
                    img.src = canvas.toDataURL('image/png');
                    img.classList.add("preview-img");
                    previewContainer.appendChild(img);

                    // **撮影した画像を `input.files` に追加**
                    canvas.toBlob(function(blob) {
                        const file = new File([blob], `${target}_captured.png`, {
                            type: "image/png"
                        });
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;
                    }, 'image/png');

                    resetButton.style.display = "block";
                    captureButton.style.display = "none";

                    stopCamera();
                }

                // 🔄 撮影・アップロード画像をリセット（プレビューのみクリア、ファイルリストは保持）
                function resetImages(target) {
                    const previewContainer = document.getElementById(`preview_${target}`);
                    const resetButton = document.getElementById(`reset_${target}`);
                    const captureButton = document.getElementById(`capture_${target}`);

                    // **プレビューエリアのみクリア**
                    previewContainer.innerHTML = '';

                    resetButton.style.display = "none";
                    captureButton.style.display = "block"; // 撮影ボタンを再表示
                }

                // 🛑 カメラを停止
                function stopCamera() {
                    if (videoStream) {
                        videoStream.getTracks().forEach(track => track.stop());
                        videoStream = null;
                    }
                    document.querySelectorAll('.camera-container').forEach(container => {
                        container.style.display = "none";
                    });
                }
            </script>
            <style>
                .preview-img {
                    max-width: 600px;
                    /* プレビュー画像を大きく */
                    height: auto;
                    border: 2px solid #000;
                    border-radius: 8px;
                    margin-right: 10px;
                    margin-bottom: 10px;
                    display: inline-block;
                }

                /* カメラプレビュー用の video 要素 */
                .camera-container video {
                    width: 100%;
                    max-width: 600px;
                    /* カメラ映像の最大サイズを指定 */
                    border: 2px solid #000;
                    border-radius: 8px;
                }
            </style>
            <button type="submit" class="btn btn-primary">次に進む</button>
        </form>
    </div>
@endsection
