<?php
session_start();
require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Symfony\Component\DomCrawler\Crawler;

$charset = 'Windows-1251';

require_once("arshin.php");
function jsonForEnd($tmp_protocol)
{
    $fio[] = explode("_", $_REQUEST['fio']);
    $f = $fio[0][0];
    $i = $fio[0][1];
    $o = $fio[0][2];
    $snils = $fio[0][3];

    foreach ($tmp_protocol as $item) {

        $checkdate = date('Y-m-d', strtotime($item['verification_date']));
        $checkuntil = date('Y-m-d', strtotime($item['valid_date']));
        $vri_id = str_replace('1-', "", $item['vri_id']);

        $data[] = [$vri_id, $checkdate, $checkuntil,
            $item['mi_modification'], $item['applicability'] == "true" ? 1 : 2,
            $f, $i, $o, $snils];
    }


    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Message></Message>');
    $xml->addAttribute('xsi:noNamespaceSchemaLocation', 'schema.xsd', 'http://www.w3.org/2001/XMLSchema-instance');
    $verificationMeasuringInstrumentData = $xml->addChild('VerificationMeasuringInstrumentData');
    foreach ($data as $row) {
        $verificationMeasuringInstrument1 = $verificationMeasuringInstrumentData->addChild('VerificationMeasuringInstrument');
        $verificationMeasuringInstrument1->addChild('NumberVerification', $row[0]);
        $verificationMeasuringInstrument1->addChild('DateVerification', $row[1]);
        $verificationMeasuringInstrument1->addChild('DateEndVerification', $row[2]);
        $verificationMeasuringInstrument1->addChild('TypeMeasuringInstrument', $row[3]);
        $approvedEmployee1 = $verificationMeasuringInstrument1->addChild('ApprovedEmployee');
        $name1 = $approvedEmployee1->addChild('Name');
        $name1->addChild('Last', $row[5]);
        $name1->addChild('First', $row[6]);
        $name1->addChild('Middle', $row[7]);
        $approvedEmployee1->addChild('SNILS', $row[8]);
        $verificationMeasuringInstrument1->addChild('ResultVerification', $row[4]);
    }
    $xml->addChild('SaveMethod', '2');
    $final_file = '.' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'final_' . time() . '.xml';
    $xml->asXML($final_file);

    $_SESSION['upl'] = true;
    return $final_file;

}

function jsonForArshin()
{
//    $fio[] = explode("_", $_REQUEST['fio']);
//    $f = $fio[0][0];
//    $i = $fio[0][1];
//    $o = $fio[0][2];
//    $snils = $fio[0][3];

//    foreach ($tmp_protocol as $item) {
//
//        $checkdate = date('Y-m-d', strtotime($item['verification_date']));
//        $checkuntil = date('Y-m-d', strtotime($item['valid_date']));
//        $vri_id = str_replace('1-', "", $item['vri_id']);
//
//        $data[] = [$vri_id, $checkdate, $checkuntil,
//            $item['mi_modification'], $item['applicability'] == "true" ? 1 : 2,
//            $f, $i, $o, $snils];
//    }



    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><gost:application xmlns:gost="urn://fgis-arshin.gost.ru/module-verifications/import/2020-06-19"></gost:application>');

    foreach ($data as $row) {
    $result1 = $xml->addChild('gost:result');
    $miInfo1 = $result1->addChild('gost:miInfo');
    $singleMI1 = $miInfo1->addChild('gost:singleMI');
    $singleMI1->addChild('gost:mitypeNumber', '0');
    $singleMI1->addChild('gost:manufactureNum', '0');
    $singleMI1->addChild('gost:modification', '0');
    $result1->addChild('gost:signCipher', 'ДМР');
    $result1->addChild('gost:miOwner', 'Нет данных');
    $result1->addChild('gost:vrfDate', '0:00:00');
    $result1->addChild('gost:validDate', '0:00:00');
    $result1->addChild('gost:type', '2');
    $result1->addChild('gost:calibration', 'false');
    $applicable1 = $result1->addChild('gost:applicable');
    $applicable1->addChild('gost:signPass', 'true');
    $applicable1->addChild('gost:signMi', 'false');
    $result1->addChild('gost:docTitle', 'МИ 1592-2015');
    $result1->addChild('gost:metrologist', 'Бражников Б.С.');
    $means1 = $result1->addChild('gost:means');
    $mieta1 = $means1->addChild('gost:mieta');
    $mieta1->addChild('gost:number', '60661.15.3Р.00809033');
    $conditions1 = $result1->addChild('gost:conditions');
    $conditions1->addChild('gost:temperature', '0');
    $conditions1->addChild('gost:pressure', '0');
    $conditions1->addChild('gost:hymidity', '0');
    }


// Форматируем XML для сохранения в файл
    $dom = new DOMDocument("1.0");
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $final_file = '.' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'final_' . time() . '.xml';
    $dom->save($final_file);


//
//
//
/*    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Message></Message>');*/
//    $xml->addAttribute('xsi:noNamespaceSchemaLocation', 'schema.xsd', 'http://www.w3.org/2001/XMLSchema-instance');
//    $verificationMeasuringInstrumentData = $xml->addChild('VerificationMeasuringInstrumentData');
//    foreach ($data as $row) {
//        $verificationMeasuringInstrument1 = $verificationMeasuringInstrumentData->addChild('VerificationMeasuringInstrument');
//        $verificationMeasuringInstrument1->addChild('NumberVerification', $row[0]);
//        $verificationMeasuringInstrument1->addChild('DateVerification', $row[1]);
//        $verificationMeasuringInstrument1->addChild('DateEndVerification', $row[2]);
//        $verificationMeasuringInstrument1->addChild('TypeMeasuringInstrument', $row[3]);
//        $approvedEmployee1 = $verificationMeasuringInstrument1->addChild('ApprovedEmployee');
//        $name1 = $approvedEmployee1->addChild('Name');
//        $name1->addChild('Last', $row[5]);
//        $name1->addChild('First', $row[6]);
//        $name1->addChild('Middle', $row[7]);
//        $approvedEmployee1->addChild('SNILS', $row[8]);
//        $verificationMeasuringInstrument1->addChild('ResultVerification', $row[4]);
//    }
//    $xml->addChild('SaveMethod', '2');
//    $final_file = '.' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'final_' . time() . '.xml';
//    $xml->asXML($final_file);

    $_SESSION['upl'] = true;
    return $final_file;

}