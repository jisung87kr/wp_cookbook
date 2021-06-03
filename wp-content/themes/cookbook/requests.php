<?php
include './classes/CookBook.php';
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