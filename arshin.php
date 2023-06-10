<?php
require_once('./vendor/autoload.php');

use Symfony\Component\HttpClient\HttpClient;


$resultArray = [];
$startCounter = file_get_contents('startfrom.txt');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'getFromArshin') {
    dataFromArshin($startCounter, $resultArray);
}

function dataFromArshin(&$startCounter, &$resultArray)
{
    $content = getFormArshin($startCounter);

    if (count(json_decode($content, true)['result']['items']) > 0) {
        $startCounter += 100;
        $resultArray[] = json_decode($content, true);

        // Проверка на ошибки при преобразовании
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Ошибка при преобразовании JSON";
        }

        dataFromArshin($startCounter, $resultArray);
    }
}

$resultArrayNew = []; // Результирующий массив для всех элементов "items"

foreach ($resultArray as $subArray) {
    // Добавляем все элементы "items" в результирующий массив
    $resultArrayNew = array_merge($resultArrayNew, $subArray['result']['items']);
}


if (isset($resultArray[0]["result"]['items'])) {
    $file = 'startfrom.txt'; // Путь к файлу, который нужно перезаписать
    $data = $resultArray[0]["result"]["count"]; // Новое содержимое файла

// Запись данных в файл, перезаписывая его содержимое
    $result = file_put_contents($file, $data);

// Проверка успешности операции
    if ($result === false) {
        echo "Загружать нечего";
    }
}

function getFormArshin($startCounter)
{
    $baseUrl = 'https://fgis.gost.ru/fundmetrology/eapi/vri?year=2023&org_title=ООО "ЭКОНОМ-РЕСУРС"&rows=100&sort=verification_date asc&start=';

// Создание клиента HttpClient
    $client = HttpClient::create();

// URL для отправки запроса
    $url = $baseUrl . $startCounter;

// Отправка запроса и получение ответа
    $response = $client->request('GET', $url);

// Получение содержимого ответа в виде строки
    return $response->getContent();
}