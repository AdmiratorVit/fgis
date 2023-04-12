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

require_once("final.php");

if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
    $name = $_FILES["filename"]["name"];

    if (!is_dir(date('m'))) {
        mkdir(date('m'));
    }

    move_uploaded_file($_FILES["filename"]["tmp_name"], $name);

    if (rename($name, '.' . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . $name)) {
        $upl = 1;
        $new_name = '.' . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . $name;
    }
}

$xml = simplexml_load_file("$new_name");
$tmp_protocol = '.' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'protocol_' . time() . '.txt';

$dir = '.' . DIRECTORY_SEPARATOR . 'tmp';
$files = scandir($dir);

foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        $filepath = $dir . "/" . $file;
        if (filemtime($filepath) < (time() - (3 * 24 * 60 * 60))) {
            unlink($filepath);
        }
    }
}

foreach ($xml->xpath('//gost:globalID') as $record) {
    file_put_contents($tmp_protocol, $record . PHP_EOL, FILE_APPEND);
}

$res = parsing_fgis($tmp_protocol);
unlink($tmp_protocol);

?>

<div class="parent">
    <div class="content">
        <div class="parent__block1">
            <div class="parent__block1_form">
                <div class="parent__block1_title">Загрузка файла XML</div>
                <?php
                if ($upl == 1) {
                    echo "Файл обработан. <a href='$res' download>Ссылка для скачивания</a>";
                    echo "<br />";
                    echo "<a href='index.html'>Вернуться назад</a>";
                    $upl = 0;
                } else {
                    $upl = 0;
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