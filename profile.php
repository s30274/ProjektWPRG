<?php
session_start();

include_once('navbar.php');
include_once('AllUsers.php');
include_once('Role.php');
include_once('ManageProduct.php');
include_once('Admin.php');

if($_SESSION['loggedin']) {
    $type = $_SESSION['type'];
    $email = $_SESSION['email'];
    if ($type === 'admin') {
        $admin = new Admin($email);
        $admin->showManager();
    } else if ($type === 'seller') {
        $seller = new Seller($email);
        $seller->showManager();
    } else {
        $user = new User($email);
    }
}