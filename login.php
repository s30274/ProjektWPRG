<?php
session_start();
include_once "navbar.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:loggedin.php");
    exit;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        span {color: #cc0000}
    </style>
</head>

<body>
<form method="post">
    <input type="text" name="email" placeholder="e-mail"><br>
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="login" class="login" value="Login"><br>
</form>

<?php
$email=$_POST['email'];
$password=$_POST['password'];

if(!empty($email)){
    if(checkLogin($email, $password)){
        $emaillow=strtolower($email);

        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $emaillow;
        header('Location:index.php');
    }
}
function checkLogin($email, $password){
    $emaillow=strtolower($email);
    return false;
}
?>

<br>Nie masz konta? <a href="register.php">Zarejestruj się</a>

</body>
</html>