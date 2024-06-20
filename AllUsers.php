<?php

class AllUsers {
    private $email, $id;
    public function __construct($email) {
        $this->email=$email;
        $db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");
        $sql = ("SELECT * FROM Users WHERE email LIKE '$email'");
        $good=true;
        try{
            $result=$db->query($sql);
        }
        catch (Exception $e){
            $good=false;
            echo $e;
        }
        if($good){
            $row=$result->fetch(PDO::FETCH_ASSOC);
            $this->id=$row['id'];
        }
    }
}