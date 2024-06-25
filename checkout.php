<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Podsumowanie - Aledrogo</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>

<?php
session_start();
include_once 'navbar.php';
include_once 'CookieManager.php';
include_once 'db.php';
global $db;

//Przekierowanie do logowania
if(!$_SESSION['loggedin']) {
    echo "<div id='redirect'><a href='login.php'>Zaloguj się</a> aby dokończyć zakup.</div>";
} else {

    //Wczytanie indeksu użytkownika
    $sql = ("SELECT id FROM Users WHERE email='$_SESSION[email]'");
    try{
        $result=$db->query($sql);
    } catch (Exception $e){
        echo $e;
    }
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $sum = $_SESSION['sum'];
    ?>

<div class="container">
    <?php
    echo "<span>"."Suma: ".number_format((float)$sum, 2, '.', '')." zł"."</span><br><br>";
    ?>
    <form method="post">
        <input type="text" name="city" placeholder="Miasto"><br><br>
        <input type="text" name="postcode" placeholder="Kod pocztowy"><br><br>
        <input type="text" name="address" placeholder="Adres"><br><br>
        <input type="submit" name="buy" value="Kup" class="button"><br>
    </form>
</div>

    <?php
    if(isset($_POST['buy'])) {
        unset($_SESSION['sum']);

        //Dodanie rekordu orders i wczytanie jego indeksu
        $sql = ("INSERT INTO Orders(city, postcode, address, sum, User_id) VALUES ('$_POST[city]', '$_POST[postcode]', '$_POST[address]', '$sum', '$id')");
        try{
            $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
        $sql = ("SELECT id FROM Orders WHERE User_id='$id' LIMIT 1");
        try{
          $result = $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $order_id = $row['id'];

        //Wczytanie przedmiotów
        $manager = new CookieManager();
        $basket = $manager->getBasket();
        $items = array();
        $amounts = array();
        for ($i = 0; $i < (sizeof($basket) / 2); $i++) {
            $items[] = $basket [($i * 2)];
            $amounts[] = $basket [(($i * 2) + 1)];
        }

        //Dodanie rekordu items
        for ($i = 0; $i < sizeof($amounts); $i++) {
            $sql = ("SELECT quantity FROM Products WHERE id='$items[$i]'");
            try {
                $result = $db->query($sql);
            }
            catch (Exception $e) {
                echo $e;
            }
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $correct_amount = ((int)min($amounts[$i], $row['quantity']));
            $sql = ("INSERT INTO Items(quantity, Product_id, Order_id) VALUES ('$correct_amount', '$items[$i]', $order_id)");
            try {
                $db->query($sql);
            }
            catch (Exception $e){
                echo $e;
            }
            $new_quantity = ((int)($row['quantity']-$correct_amount));
            $sql = ("UPDATE Products
                SET quantity='$new_quantity'
                WHERE id=$items[$i];
            ");
            try {
                $db->query($sql);
            }
            catch(Exception $e){
                echo $e;
            }
        }
        $manager->clearBasket();
    }
}
?>

</body>
</html>