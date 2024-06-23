<?php
session_start();
include_once "navbar.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:index.php");
    exit;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logowanie - Aledrogo</title>
    <style>
        .body {
            margin: 30px;
        }
        span {color: #cc0000}
    </style>
</head>
<body>

<div class="body">
<h1>Logowanie</h1><br>
<form method="post">
    <input type="text" name="email" placeholder="e-mail"><br>
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="login" class="login" value="Login"><br>
</form>

<?php

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!empty($email)) {
        $check=checkLogin($email, $password);
        if ($check[0]==1) {
            $emaillow = strtolower($email);
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $emaillow;
            $_SESSION['type'] = $check[1];
            $_SESSION['active'] = $check[2];
        }
        else{
            echo "<span>Podano niewłaściwe dane logowania</span>";
        }
    }
}
function checkLogin($email, $password){
    $emaillow=strtolower($email);
    $db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");
    $result = $db->query("SELECT * FROM Users WHERE email LIKE '$emaillow'");
    $row=$result->fetch(PDO::FETCH_ASSOC);
    if(empty($row)){
        return false;
    }
    else{
        $hash=$row['password'];
        if(password_verify($password, $hash)){
            return array(1, $row['type'], $row['active']);
        }
        else{
            return array(0, 0, 0);
        }
    }
}
?>

<br>Nie masz konta? <a href="register.php">Zarejestruj się</a>
</div>

</body>
</html>