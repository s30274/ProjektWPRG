<?php

class Seller implements Role{
    use ManageProduct;

    public function __construct($email) {
        parent::__construct($email);
    }
}