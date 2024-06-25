<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil - Aledrogo</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<?php
session_start();
include_once('navbar.php');
include_once('AllUsers.php');
include_once('ManageProduct.php');
include_once('Admin.php');
include_once('Seller.php');
include_once('User.php');

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
else {
    header("Location:index.php");
}
?>

</body>
</html>