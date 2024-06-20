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
<div class="logo">
    <a href="index.php"><img src="Images/logo.png" height="75px"></a>
</div>
<div class="navbar">
    <ul class="navbarlist">
        <li class="navbarelementleft"><a href="index.php" class="navbarlink">Strona główna</a></li>
        <li class="navbarelementleft"><a href="contact.php" class="navbarlink">Kontakt</a></li>
        <li class="navbarelementleft"><a href="about.php" class="navbarlink">O nas</a></li>
        <li class="searchbar">
            <form method="get" action="search.php" class="navbarsearch">
                <input type="text" name="searchphrase" placeholder="czego szukasz?" class="search">
                <input type="submit" name="search" value="Szukaj" class="searchbutton">
            </form>
        </li>
        <?php
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        ?>
            <li class="navbarelementright"><a href="logout.php" class="navbarlink">Wyloguj się</a></li>
            <li class="navbarelementright"><a href="profile.php" class="navbarlink">Profil</a></li>
        <?php
        } else {
        ?>
            <li class="navbarelementright"><a href="register.php" class="navbarlink">Zarejestruj się</a></li>
            <li class="navbarelementright"><a href="login.php" class="navbarlink">Zaloguj się</a></li>
        <?php
        }
        ?>

    </ul>
</div>
<br>
</body>
</html>