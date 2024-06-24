<?php

class CookieManager {
    private $arr, $cookie_name;

    public function __construct($cookie_name){
        $this->cookie_name = $cookie_name;
        if(isset($_COOKIE[$cookie_name])){
            $data = $_COOKIE[$cookie_name];
            $this->arr = explode(";", $data);
        } else {
            $this->arr = array();
        }
    }

    public function addValue2($value1, $value2, $quantity){
        if (!in_array($value1, $this->arr))
        {
            $this->arr[] = $value1;
            $this->arr[] = $value2;
        }
        else {
            $key = array_search($value2, $this->arr);
            $key++;
            $amount = $this->arr[$key];
            $amount += $value2;
            $this->arr[$key] = min($amount, $quantity);
        }
        $string = implode(";", $this->arr);

        //Ciasteczko ważne przez 1 godzinę
        setcookie($this->cookie_name, $string, time()+3600);
    }

    public function addValueWithLimit($value, $limit){
        if (!in_array($value, $this->arr))
        {
            if(sizeof($this->arr)>=$limit) {
                array_splice($this->arr, 0, 1);
            }
            $this->arr[] = $value;
        }
        $string = implode(";", $this->arr);

        //Ciasteczko ważne przez 1 godzinę
        setcookie($this->cookie_name, $string, time()+3600);
    }

    public function getSize(){
        return sizeof($this->arr);
    }
    public function getArray(){
        return $this->arr;
    }
}