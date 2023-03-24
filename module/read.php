<?php
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;

$reader = new Reader;
$file_name = 'excel/read.xlsx';
$spreadsheet = $reader->load($file_name);

// シートの読み込み
$sheet = $spreadsheet->getActiveSheet();

// 値の取得
$URL = $sheet->getCell('A2')->getValue();
$value = $sheet->getCell('C5')->getValue();

echo $URL;
echo $value;