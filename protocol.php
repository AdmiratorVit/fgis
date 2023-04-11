<!DOCTYPE html>
<html>
<head>
    <title>BY ADMIRATOR</title>
    <meta charset="utf-8"/>
</head>
<body>
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
<h2>Загрузка файла</h2>
<?php
if ($upl == 1) {
    echo "Файл обработан. <a href='$res'>Ссылка для скачивания</a>";
    echo "<br />";
    echo "<a href='index.html'>Вернуться назад</a>";
    $upl = 0;
} else {
    $upl = 0;
}
?>

</body>
</html>