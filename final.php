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
            $modificationsi = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(1) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text();
            $checkdate = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(5) > td:nth-child(2)')->text();
            $checkuntil = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(6) > td:nth-child(2)')->text();
            $isgood = $crawler->filter('body > div > div > div.content > div > div > div.col-md-34.col-sm-36.overlay-wrapper > div:nth-child(2) > div > table > tbody > tr:nth-child(8) > td:nth-child(2)')->text();

            $checkdate = date('Y-m-d', strtotime($checkdate));
            $checkuntil = date('Y-m-d', strtotime($checkuntil));
            $data[] = [trim($line), $checkdate, $checkuntil, $modificationsi, $isgood == "Да" ? 1 : 2, $f, $i, $o, $snils];
        }
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

    $driver->quit();
    return $final_file;
}