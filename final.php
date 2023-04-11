<?php
require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Symfony\Component\DomCrawler\Crawler;

$charset = 'Windows-1251';
function parsing_fgis($tmp_protocol)
{
    $host = 'http://localhost:4444/wd/hub';
    $capabilities = DesiredCapabilities::chrome();
    $driver = RemoteWebDriver::create($host, $capabilities);

    $file = fopen($tmp_protocol, "r") or die("Unable to open file!");

    $fio[] = explode("_", $_REQUEST['fio']);
    $f = $fio[0][0];
    $i = $fio[0][1];
    $o = $fio[0][2];
    $snils = $fio[0][3];

// читаем файл построчно
    while (!feof($file)) {
        $line = fgets($file);
        if ($line) {
            $driver->get('https://fgis.gost.ru/fundmetrology/cm/results/' . $line);

            $wait = new WebDriverWait($driver, 10);
            $element = $wait->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath("//div[@class='page-result']"))
            );

            $html = $driver->getPageSource();

            $crawler = new Crawler($html);
            $regnumsi = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(1) > td:nth-child(2) > a')->text();
//            $typesi = "typesi: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(2)')->text();
//            $titletypesi = "titletypesi: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(2)')->text();
//            $factopynumsi = "factopynumsi: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(2)')->text();
            $modificationsi = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text();
//            $modificationsi = "modificationsi: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text();
//            $checkername = "checkername: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(1) > td:nth-child(2)')->text();
//            $cipher = "cipher: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(2) > td:nth-child(2)')->text();
//            $owner = "owner: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(3) > td:nth-child(2)')->text();
//            $checktype = "checktype: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(4) > td:nth-child(2)')->text();
//            $checkdate = "checkdate: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text();
            $checkdate = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text();
//            $checkuntil = "checkuntil: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(6) > td:nth-child(2)')->text();
            $checkuntil = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(6) > td:nth-child(2)')->text();
//            $docname = "docname: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(7) > td:nth-child(2)')->text();
            $isgood = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(8) > td:nth-child(2)')->text();
//            $isgood = "isgood: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(8) > td:nth-child(2)')->text();
//            $certificatenum = "certificatenum: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(9) > td:nth-child(2)')->text();
//            $checksign = "checksign: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(10) > td:nth-child(2)')->text();
//            $checksignonsi = "checksignonsi: " . $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(11) > td:nth-child(2)')->text();

            $data[] = [$regnumsi, $checkdate, $checkuntil, $modificationsi, $isgood == "Да" ? 1 : 2, $f, $i, $o, $snils];

//            array_push($json, [
//                "arshNum" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(1) > td:nth-child(2) > a')->text(),
//                "typesi" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(2) > td:nth-child(2)')->text(),
//                "titletypesi" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(3) > td:nth-child(2)')->text(),
//                "factopynumsi" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(4) > td:nth-child(2)')->text(),
//                "modificationsi" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text(),
//                "checkername" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(1) > td:nth-child(2)')->text(),
//                "cipher" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(2) > td:nth-child(2)')->text(),
//                "owner" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(3) > td:nth-child(2)')->text(),
//                "checktype" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(4) > td:nth-child(2)')->text(),
//                "checkdate" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text(),
//                "checkuntil" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(6) > td:nth-child(2)')->text(),
//                "docname" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(7) > td:nth-child(2)')->text(),
//                "isgood" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(8) > td:nth-child(2)')->text(),
//                "verifSurname" => $_REQUEST['fio'],
//                "certificatenum" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(9) > td:nth-child(2)')->text(),
//                "checksign" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(10) > td:nth-child(2)')->text(),
//                "checksignonsi" => $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(11) > td:nth-child(2)')->text()
//            ]);
        }
//        $json = json_encode("regnumsi", $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(1) > td:nth-child(2) > a')->text());
    }
//    $json = json_encode($json);
//
//    $protocol_answer_name = '.' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'protocol_answer_' . time() . '.json';
//    file_put_contents($protocol_answer_name, $json, FILE_APPEND);



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
    $xml->addChild('SaveMethod', '1');
    $final_file = '.' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'final_' . time() . '.xml';
    $xml->asXML($final_file);


//    foreach ($data as $row) {
//        global $charset;
//        $row = array_map(function($value) use ($charset) {
//            return iconv('UTF-8', $charset, $value);
//        }, $row);
//
//        fputcsv($final_file, $row);
//    }
//    fclose($final_file);

//    file_put_contents($final_file, "let data = ", FILE_APPEND);
//    file_put_contents($final_file, $json, FILE_APPEND);
//    $end = file_get_contents("end.txt");
//    file_put_contents($final_file, $end, FILE_APPEND);

    $driver->quit();
    return $final_file;
}