<?php
class CookBook{
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
        foreach ($_SESSION['addRefrigerator'] as $index => $item) {
            if($item['term_id'] == $request['term_id']){
                unset($_SESSION['addRefrigerator'][$index]);
            }
        }
    }
}