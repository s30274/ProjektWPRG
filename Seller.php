<?php

class Seller extends AllUsers {
    use ManageProduct;
    use OrdersManager;

    public function __construct($email) {
        parent::__construct($email);
    }
}