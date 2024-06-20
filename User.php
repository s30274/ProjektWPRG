<?php

class User implements Role {
    function __construct($email){
        parent::__construct($email);
    }
}