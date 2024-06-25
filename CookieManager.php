<?php

class CookieManager {
    private function getData($cookie_name){
        $arr = array();
        if(isset($_COOKIE[$cookie_name])){
            $data = $_COOKIE[$cookie_name];
            $arr = explode(";", $data);
        }
        return $arr;
    }

    public function addBasket($value1, $value2, $quantity){
        $arr = $this->getData('basket');
        if (!in_array($value1, $arr))
        {
            $arr[] = $value1;
            $arr[] = $value2;
        }
        else {
            $key = array_search($value1, $arr);
            $key++;
            $amount = $arr[$key];
            $amount += $value2;
            $arr[$key] = min($amount, $quantity);
        }
        $string = implode(";", $arr);

        //Ciasteczko ważne przez 1 godzinę
        setcookie('basket', $string, time()+3600);
    }

    public function addRecent($value){
        $arr = $this->getData('recent');
        if (!in_array($value, $arr))
        {
            if(sizeof($arr)>=4) {
                array_splice($arr, 0, 1);
            }
            $arr[] = $value;
        }
        $string = implode(";", $arr);

        //Ciasteczko ważne przez 1 godzinę
        setcookie('recent', $string, time()+3600);
    }
    public function clearBasket(){
        setcookie('basket', "", time()+3600);
    }
    public function getBasket(){
        return $this->getData('basket');
    }
    public function getRecent(){
        return $this->getData('recent');
    }
}