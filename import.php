<?php
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
// 読み用
$reader = new Reader;
$fileName = 'excel/import.xlsx';
$spreadsheet = $reader->load($fileName);

// シートの読み込み
// $sheet = $spreadsheet->getActiveSheet();

// シートの総数取得
$sheetCount = $spreadsheet->getSheetCount();

// シート毎にデータを取得
for ($i=0; $i < $sheetCount; $i++) {
    // シートの取得
    $sheet = $spreadsheet->getSheet($i);
    // シート名を取得する
    $sheetName = $sheet->getTitle();
    $valueAll[] = $sheet->rangeToArray('C6:H50');
    $ingredient = array();
    // 食材ごとにデータをトリム
    for ($j=0; $j < count($valueAll[$i]); $j++) {
        $ingredientName = trim(mb_convert_kana($valueAll[$i][$j][0], "s")); // 食材
        $gram = trim($valueAll[$i][$j][2]); // 一人当たりのg

        // ■を持つ食材の取得
        preg_match('/■/u', $ingredientName, $square);
        if(!empty($square)){
            $ingredient[] = array("sheet名"=>$sheetName,"分類"=>"食材","食材名"=>$ingredientName,"一人当たりg"=>$gram);
        }
        // おやつの取得
        // 3時をキーにしてそれ以降取得
        preg_match('/３\s*時/u', $ingredientName, $threeOClock);
        if(!empty($threeOClock) || $threeOClockFlag == true){
            $threeOClockFlag = true;
            $afternoonTea[] = array("sheet名"=>$sheetName,"分類"=>"おやつ","食材名"=>$ingredientName,"一人当たりg"=>$gram);
        }
    }
    $threeOClockFlag = false;
    $ingredientList[$i] = $ingredient;
    $afternoonTeaList[$i] = $afternoonTea;
}

$ingredientName = array();
// 日数分ループ
for ($i=0; $i < count($ingredientList); $i++) {
    // 食材分ループ
    for ($j=0; $j < count($ingredientList[$i]); $j++) {
        $ingredientNameList[$ingredientList[$i][$j]["食材名"]] = $ingredientList[$i][$j]["食材名"];
        // 食材名が有れば加算
        if(in_array($ingredientList[$i][$j]["食材名"],$ingredientNameList)){
            $ingredientGram[$ingredientList[$i][$j]["食材名"]] = $ingredientGram[$ingredientList[$i][$j]["食材名"]] + $ingredientList[$i][$j]["一人当たりg"]; // まとめ用
            $ingredientGramDetails[] = array($ingredientList[$i][$j]["食材名"] => $ingredientList[$i][$j]["一人当たりg"]); // 詳細用
        }
    }
    // おやつループ
    for ($j=0; $j < count($afternoonTeaList[$i]); $j++) {
        if($afternoonTeaList[$i][$j]["食材名"]){
            $afternoonTeaNameList[$afternoonTeaList[$i][$j]["食材名"]] = $afternoonTeaList[$i][$j]["食材名"];
            // 食材名が有れば加算
            if(in_array($afternoonTeaList[$i][$j]["食材名"],$afternoonTeaNameList)){
                $afternoonTeaGram[$afternoonTeaList[$i][$j]["食材名"]] = $afternoonTeaGram[$afternoonTeaList[$i][$j]["食材名"]] + $afternoonTeaList[$i][$j]["一人当たりg"]; // まとめ用
                $afternoonTeaGramDetails[] = array($afternoonTeaList[$i][$j]["食材名"] => $afternoonTeaList[$i][$j]["一人当たりg"]); // 詳細用
            }
        }
    }
}

print_r('<pre>'); print_r($afternoonTeaGramDetails); print_r('</pre>');

// 書き込み用
$writeSpreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$writeSheet = $writeSpreadsheet->getActiveSheet();
// シートのタイトルを設定する
$writeSheet->setTitle('食材');
$i = 2;
foreach ($ingredientGram as $key => $value) {
    $column_A = "A".$i;
    $column_B = "B".$i;
    $writeSheet->setCellValue("A1", "食材名");
    $writeSheet->setCellValue("B1", "一人当たりg");
    $writeSheet->setCellValue($column_A, $key);
    $writeSheet->setCellValue($column_B, $value);
    $i += 1;
}

// 新しいシートを作成する
$writeSheet = $writeSpreadsheet->createSheet();
// シートのタイトルを設定する
$writeSheet->setTitle('おやつ');
$i = 2;
foreach ($afternoonTeaGram as $key => $value) {
    $column_A = "A".$i;
    $column_B = "B".$i;
    $writeSheet->setCellValue("A1", "食材名");
    $writeSheet->setCellValue("B1", "一人当たりg");
    $writeSheet->setCellValue($column_A, $key);
    $writeSheet->setCellValue($column_B, $value);
    $i += 1;
}

// 新しいシートを作成する
$writeSheet = $writeSpreadsheet->createSheet();
// シートのタイトルを設定する
$writeSheet->setTitle('食材詳細');
$i = 2;
for ($j=0; $j < count($ingredientGramDetails); $j++) { 
    foreach ($ingredientGramDetails[$j] as $key => $value) {
        $column_A = "A".$i;
        $column_B = "B".$i;
        $writeSheet->setCellValue("A1", "食材名");
        $writeSheet->setCellValue("B1", "一人当たりg");
        $writeSheet->setCellValue($column_A, $key);
        $writeSheet->setCellValue($column_B, $value);
        $i += 1;
    }
}

// 新しいシートを作成する
$writeSheet = $writeSpreadsheet->createSheet();
// シートのタイトルを設定する
$writeSheet->setTitle('おやつ詳細');
$i = 2;
for ($j=0; $j <count($afternoonTeaGramDetails) ; $j++) { 
    foreach ($afternoonTeaGramDetails[$j] as $key => $value) {
        $column_A = "A".$i;
        $column_B = "B".$i;
        $writeSheet->setCellValue("A1", "食材名");
        $writeSheet->setCellValue("B1", "一人当たりg");
        $writeSheet->setCellValue($column_A, $key);
        $writeSheet->setCellValue($column_B, $value);
        $i += 1;
    }
}

$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($writeSpreadsheet);
$writer->save('excel/result.xlsx');