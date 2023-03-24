<?php
require_once "vendor/autoload.php";
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ここで $sheet を通してセルなどを操作します。

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('excel/read.xlsx');