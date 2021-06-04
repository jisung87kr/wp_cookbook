<?php
include $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use CookBook\Classes\CookBook;
$CB = new CookBook;
if($_REQUEST['act']){
    switch($_REQUEST['act']){
        case 'addRefrigerator':
            $CB->addRefrigerator($_REQUEST);
            break;
        case 'deleteRefrigerator':
            $CB->deleteRefrigerator($_REQUEST);
            break;
    }
    exit;
}