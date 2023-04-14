<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食材管理表作成</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <form action="index.php" method="post">
        <button class="btn" type="submit" name="totalization" value="true">集 計</button>
    </form>
</body>
</html>


<?php
    // セッション
    session_start();
    $_SESSION['check'] = $_POST;
    require_once('import.php');

    $import = new Import;
    if($_SESSION['check'] == true){
        $import->totalization();
    }
?>