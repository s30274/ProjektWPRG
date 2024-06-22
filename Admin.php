<?php

class Admin extends AllUsers {
    use ManageProduct;

    public function __construct($email){
        parent::__construct($email);
    }
}