<!-- ファイルアップロード時に既存のファイルを削除します -->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['files'])) {
    $files = $_POST['files'];
    $baseDirectory = "/home/kskxfree/kskxfree.wp.xdomain.jp/public_html/excel/";

    $response = array();

    foreach ($files as $file) {
      $filepath = $baseDirectory . $file;

      if (file_exists($filepath)) {
        if (unlink($filepath)) {
          $response[] = array('file' => $file, 'success' => true, 'message' => 'ファイルの削除が成功しました');
        } else {
          $response[] = array('file' => $file, 'success' => false, 'message' => 'ファイルの削除中にエラーが発生しました');
        }
      } else {
        $response[] = array('file' => $file, 'success' => false, 'message' => '指定されたファイルが存在しません');
      }
    }

    echo json_encode($response);
  }
}
?>