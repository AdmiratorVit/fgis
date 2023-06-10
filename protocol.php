<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загрузка файла XML</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/main.css">
    <link rel="icon" href="./img/favicon.svg" type="image/svg+xml">
</head>
<body class="no_scroll">
<?php
global$resultArrayNew;
require_once("finalNew.php");

//$res = parsing_fgis($tmp_protocol);
$res = jsonForEnd($resultArrayNew);

?>


<div class="parent">
    <div class="content">
        <div class="parent__block1">
            <div class="parent__block1_form">
                <div class="parent__block1_title">Загрузка файла XML</div>
                <?php
                if ($_SESSION['upl'] === true) {
                    echo "Файл обработан. <a href='$res' download>Ссылка для скачивания</a>";
                    echo "<br />";
                    echo "<a href='index.html'>Вернуться назад</a>";
                    unset ($_SESSION['upl']);
                } else {
                    unset ($_SESSION['upl']);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="footer_index">
        <div class="QA">Название сервиса</div>
        <div class="admirator">Coding by <a href="https://t.me/AdmiratorV">Admirator</a></div>
    </div>
</div>
</body>
</html>