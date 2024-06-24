<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        .err {color: #cc0000}
    </style>
</head>
<body>
<?php
session_start();
?>
<div>
    <h1>Aktywuj konto</h1>
    <form method="post">
        <input type="number" name="code" placeholder="Kod aktywacji">
        <input type="submit" name="entercode" value="Aktywuj konto">
    </form>
</div>
<?php
include_once "db.php";
global $db;
if($_SESSION['loggedin']) {
    $result = $db->query("SELECT * FROM Users WHERE email LIKE '$_SESSION[email]'");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $active = $row['active'];
    if (isset($_POST['entercode'])) {
        if ($row['code'] == $_POST['code']) {
            $active = true;
        } else {
            echo "<span class='err'>Podano zły kod aktywacji</span><br><br>";
        }
    }
    if ($active) {
        $sql = ("UPDATE Users
    SET active=1
    WHERE email='$_SESSION[email]'");
        try {
            $db->query($sql);
        } catch (Exception $e) {
            echo $e;
        }
        $_SESSION['active'] = true;
        header('Location:index.php');
    } else {
        echo $row['code'] . "<br><br>";   //TEMPORARY displaying activation code for user
        echo "<span>Problem z aktywacją? </span><a href='logout.php'>Wyloguj się</a>";
    }
} else{
    header("Location:index.php");
}
?>
</body>