<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食材管理表作成</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div class="header">
        <h1>Food Management App</h1>
        <div class="container">
            <ul>
                <li>アップロードするExcelのファイル名を「import.xlsx」にしてください</li>
                <li>ファイルを選択したらアップロードボタンをおしてください</li>
                <li>「アップロードが完了しました」のメッセージが出たら「集計」を押してください</li>
                <li>集計が完了したらダウンロードリンクをクリックしてください</li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="file" id="fileInput">
            <input type="submit" value="アップロード" id="uploadButton">
        </form>

        <form id="resultForm" action="index.php" method="post">
            <button class="btn" type="submit" name="totalization" value="true">集 計</button>
        </form>
        <div id="result"></div>
        <script src="upload.js"></script>
    </div>
</body>


</html>


<?php
// PHPエラーを非表示
error_reporting(0);
// セッション
session_start();
$_SESSION['check'] = $_POST;
require_once('import.php');

$import = new Import;
if ($_SESSION['check'] == true) {
    $import->totalization();
}
?>