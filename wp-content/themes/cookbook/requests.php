<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
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
        case 'addFavorite':
            $metaKey = 'cookbook_favorite';
            add_post_meta($_REQUEST['post_id'], $metaKey, get_current_user_id());
            break;
        case 'deleteFavorite':
            $metaKey = 'cookbook_favorite';
            delete_post_meta($_REQUEST['post_id'], $metaKey, get_current_user_id());
            break;
    }
    exit;
}