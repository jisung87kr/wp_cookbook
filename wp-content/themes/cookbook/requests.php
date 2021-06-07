<?php
include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use CookBook\Classes\Refrigerator;
$Refrigerator = new Refrigerator;
$addRefrigerator = $Refrigerator::addRefrigerator;
$deleteRefrigerator = $Refrigerator::deleteRefrigerator;
if($_REQUEST['act']){
    switch($_REQUEST['act']){
        case $addRefrigerator:
            $Refrigerator->addRefrigerator($_REQUEST);
            break;
        case $deleteRefrigerator:
            $Refrigerator->deleteRefrigerator($_REQUEST);
            break;
    }
    exit;
}