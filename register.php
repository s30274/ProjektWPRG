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
    <title>Rejestracja - Aledrogo</title>
    <style>
        span {color: #cc0000}
        embed {padding: 0; margin: 0}
    </style>
</head>

<body>
<form method="post">
    <input type="text" name="username" placeholder="Nazwa użytkownika"><br><br>
    <input type="text" name="email" placeholder="Adres e-mail"><br><br>
    <input type="password" name="password" placeholder="Hasło"><br><br>
    <input type="password" name="confirm" placeholder="Potwierdź hasło"><br><br>
    <select type="type" name="type" placeholder="Typ konta">
        <option value="user">Użytkownik</option>
        <option value="seller">Sprzedawca</option>
    </select>
    <input type="submit" name="register" class="register" value="Zarejestruj się"><br>
</form>

<?php
$db = new mysqli("localhost", "root", "", "sklep");
$sql=("");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $type = $_POST['type'];

    if(isset($_POST['register'])) {
        if (checkUsername($username, $db)) {
            if (checkEmail($email, $db)) {
                if (checkPassword($password)) {
                    if ($password === $confirm) {
                        $emaillow = strtolower($email);
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $rand = rand(100000,999999);
                        $sql = ("INSERT INTO Users (username, email, password, code, type) VALUES ('$username', '$emaillow', '$hash', '$rand', '$type')");
                        try{
                            $db->query($sql);
                        }
                        catch(Exception $e){
                            echo $e;
                        }
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $emaillow;
                        $_SESSION["type"] = $type;
                        $_SESSION["active"] = false;
                        header('Location:index.php');
                    }
                    else{
                        echo "<span class='err'>Podane hasła nie są identyczne</span><br>";
                    }
                }
            }
        }
    }
    function checkPassword($password) {
        $good=true;
        $lowerCase = preg_match('/[a-z]/', $password);
        $upperCase = preg_match('/[A-Z]/', $password);
        $numericVal = preg_match('/[0-9]/', $password);
        $specialChar = preg_match('/[^A-Za-z0-9]/', $password);
        if(strlen($password)<8){
            echo "<span class='err'>Hasło musi mieć więcej niż 8 znaków</span><br>";
            $good=false;
        }
        if(!$lowerCase){
            echo "<span class='err'>Hasło musi zawierać co najmniej 1 małą literę</span><br>";
            $good=false;
        }
        if(!$upperCase){
            echo "<span class='err'>Hasło musi zawierać co najmniej 1 wielką literę</span><br>";
            $good=false;
        }
        if(!$numericVal){
            echo "<span class='err'>Hasło musi zawierać co najmniej 1 cyfrę</span><br>";
            $good=false;
        }
        if(!$specialChar){
            echo "<span class='err'>Hasło musi zawierać co najmniej 1 znak specjalny</span><br>";
            $good=false;
        }
        if($good){
            return true;
        }
        else{
            return false;
        }
    }
    function checkUsername($username, $db){
        if(strlen($username)<5){
            echo "<span class='err'>Nazwa użytkownika powinna mieć co najmniej 5 znaków</span>";
            return false;
        }
        if(strlen($username)>32){
            echo "<span class='err'>Nazwa użytkownika może mieć maksymalnie 32 znaki</span>";
            return false;
        }
        $sql=("SELECT COUNT(id) FROM Users WHERE username like '$username'");
        try{
            $row=mysqli_fetch_array($db->query($sql));
        }
        catch(Exception $e){
            echo $e;
        }
        if($row['COUNT(id)']==0){
            return true;
        }
        else{
            echo "<span class='err'>Podana nazwa użytkownika jest już zajęta</span><br>";
            return false;
        }
    }
    function checkEmail($email, $db){
        if(!empty($email)) {
            $emaillow = strtolower($email);
            $sql = ("SELECT COUNT(id) FROM Users WHERE email like '$emaillow'");
            try {
                $row = mysqli_fetch_array($db->query($sql));
            }
            catch(Exception $e){
                echo $e;
            }
            if ($row['COUNT(id)'] == 0) {
                return true;
            } else {
                echo "<span class='err'>Podany e-mail jest już zajęty</span><br>";
                return false;
            }
        }
        else {
            echo "<span class='err'>Pole e-mail nie może być puste</span><br>";
        }
    }
?>

<br>Masz już konto? <a href="login.php">Zaloguj się</a>

</body>
</html>