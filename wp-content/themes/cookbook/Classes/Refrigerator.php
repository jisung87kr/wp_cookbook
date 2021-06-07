<?php
namespace CookBook\Classes;
class Refrigerator{
    const addRefrigerator = 'addRefrigerator';
    const deleteRefrigerator = 'deleteRefrigerator';

    public function __construct()
    {

    }

    public function addRefrigerator($request)
    {
        session_start();
        $_SESSION[$request['act']][] = [
            'term_id' => $request['term_id'],
            'term'    => $request['term'],
        ];
        $result = json_encode($request);
        echo $result;
    }

    public function deleteRefrigerator($request)
    {
        session_start();
        foreach ($_SESSION[SELF::addRefrigerator] as $index => $item) {
            if($item['term_id'] == $request['term_id']){
                unset($_SESSION[SELF::addRefrigerator][$index]);
            }
        }
    }

    public function hasAddRefrigerator()
    {
        if($_SESSION[SELF::addRefrigerator]){
            return true;
        }
        return false;
    }

    public function getTerms()
    {
        return wp_list_pluck($_SESSION[SELF::addRefrigerator], 'term_id');
    }
}