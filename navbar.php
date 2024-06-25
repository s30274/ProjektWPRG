<?php
session_start();
if(isset($_SESSION['active'])){
    if(!$_SESSION['active']) {
        header('Location:activate.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<div id="logo">
    <a href="index.php"><img src="Images/logo.png" height="75px"></a>
</div>
<div class="navbar">
    <div class="navbarelement"><a href="index.php" class="navbarlink">Strona główna</a></div>
    <div class="navbarelement"><a href="contact.php" class="navbarlink">Kontakt</a></div>
    <div class="navbarelement"><a href="about.php" class="navbarlink">O nas</a></div>
    <div class="searchbar">
        <form method="get" action="search.php" class="navbarsearch">
            <input type="text" name="searchphrase" placeholder="czego szukasz?">
            <input type="submit" name="search" value="Szukaj">
        </form>
    </div>
    <div class="navbarelementright"><a href="basket.php" class="navbarlink">Koszyk</a></div>
    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    ?>
        <div class="navbarelement"><a href="profile.php" class="navbarlink">Profil</a></div>
        <div class="navbarelement"><a href="logout.php" class="navbarlink">Wyloguj się</a></div>
    <?php
    } else {
    ?>
        <div class="navbarelement"><a href="login.php" class="navbarlink">Zaloguj się</a></div>
        <div class="navbarelement"><a href="register.php" class="navbarlink">Zarejestruj się</a></div>
    <?php
    }
    ?>
</div><br>

</body>
</html>