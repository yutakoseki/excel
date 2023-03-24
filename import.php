<?php
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;

$reader = new Reader;
$fileName = 'excel/import.xlsx';
$spreadsheet = $reader->load($fileName);

// シートの読み込み
// $sheet = $spreadsheet->getActiveSheet();

// シートの総数取得
$sheetCount = $spreadsheet->getSheetCount();

// シート毎にデータを取得
for ($i=0; $i < $sheetCount; $i++) {
    $sheet = $spreadsheet->getSheet($i);
    $valueAll[] = $sheet->rangeToArray('C6:H50');
    $ingredient = array();
    // 食材ごとにデータをトリム
    for ($j=0; $j < count($valueAll[$i]); $j++) {
        $ingredientName = trim(mb_convert_kana($valueAll[$i][$j][0], "s"));
        $gram = trim($valueAll[$i][$j][2]);
        $comment = trim($valueAll[$i][$j][5]);
        $ingredient[$j] = array("食材名"=>$ingredientName,"一人当たりg"=>$gram,"コメント"=>$comment);
    }
    $ingredientList[$i] = $ingredient;
    print_r('<pre>'); print_r($ingredientList); print_r('</pre>');
}


// シートの取得
// $sheetCount = $spreadsheet->getSheetCount();
// for ($i=0; $i < $sheetCount; $i++) {
//     $sheet = $spreadsheet->getSheet($i);
//     // 値の取得
//     $valueAll[] = $sheet->rangeToArray('C6:H50');
//     print_r('<pre>'); print_r($valueAll[$i]); print_r('</pre>');
//     echo "_________________________________________________________";
//     echo "<br>";
// }

