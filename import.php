<?php
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;

$reader = new Reader;
$fileName = 'excel/import.xlsx';
$spreadsheet = $reader->load($fileName);

// シートの読み込み
$sheet = $spreadsheet->getActiveSheet();

// シートの取得
$sheetCount = $spreadsheet->getSheetCount();
for ($i=0; $i < $sheetCount; $i++) {
    $sheet = $spreadsheet->getSheet($i);
    // 値の取得
    $valueAll[] = $sheet->rangeToArray('C6:H50');
    print_r('<pre>'); print_r($valueAll[$i]); print_r('</pre>');
    echo "_________________________________________________________";
    echo "<br>";
}

