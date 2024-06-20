<?php

class Admin extends AllUsers implements Role {
    use ManageProduct;

    public function __construct($email){
        parent::__construct($email);
    }
}