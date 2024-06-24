<?php
include_once "db.php";
class AllUsers {
    protected $email, $id;
    public function __construct($email) {
        global $db;
        $this->email=$email;
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