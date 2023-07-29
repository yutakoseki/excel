<?php
$file = $_GET['file'];
$fileName = basename($file);
if (file_exists($file)) {
  // MIMEタイプをExcelに設定
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
    
    // バッファリングされたデータをクリア
    ob_clean();
    flush();

    readfile($file);
    exit;
} else {
  echo "ファイルが見つかりません。";
}
