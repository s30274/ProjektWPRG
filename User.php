<?php

class User extends AllUsers {
    use OrdersManager;
    function __construct($email){
        parent::__construct($email);
    }
}