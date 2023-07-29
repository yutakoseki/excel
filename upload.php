<!-- 一時フォルダにアップロードされたファイルを移動します -->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    echo $file;

    // ファイルの一時保存先パス
    $tempFilePath = $file['tmp_name'];
    // $targetFile = "/Users/ksk/develop/excel/excel/" . $_FILES["file"]["name"];
    $targetFile = "/home/kskxfree/kskxfree.wp.xdomain.jp/public_html/excel/excel/" . $_FILES["file"]["name"];

    // アップロードされたファイルを移動する
    if (move_uploaded_file($tempFilePath, $targetFile)) {
      echo "ファイルがアップロードされました。";
    } else {
      $error = error_get_last();
      echo "ファイルの移動中にエラーが発生しました: " . $error["message"];
    }
  } else {
    echo "ファイルのアップロード中にエラーが発生しました。";
  }

  // 処理結果を返す（例: 成功した場合は処理結果をJSON形式で返す）
  $response = array('success' => true, 'message' => 'ファイルが正常に処理されました。');
  echo json_encode($response);
}
