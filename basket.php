<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Koszyk - Aledrogo</title>
    <link rel="stylesheet" href="basket.css">
</head>
<body>

<?php
session_start();
include_once "navbar.php";
include_once "CookieManager.php";
include_once "db.php";
global $db;
$manager = new CookieManager();
$basket = $manager->getBasket();
$items = array();
$amounts = array();
$sum = 0;
for($i = 0; $i<(sizeof($basket)/2); $i++){
    $items[] = $basket [($i*2)];
    $amounts[] = $basket [(($i*2)+1)];
}
echo "<div class='basket'>";
if(sizeof($items)>0){
echo "<table>";
for($i = 0; $i<sizeof($items); $i++){
    $sql = ("SELECT name, price, quantity FROM Products WHERE id='$items[$i]'");
    try {
        $result = $db->query($sql);
    }
    catch (Exception $e) {
        echo $e;
    }
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $correct_amounts[$i] = min($amounts[$i], $row['quantity']);
    ?>
        <tr>
            <td class="column"><a href="product.php?id=<?php echo $items[$i] ?>"><img src="Products/<?php echo $items[$i] ?>" alt="<?php echo $items[$i] ?>" class="productimg"></a></td>
            <td class="column"><?php echo $row['name'] ?></td>
            <td class="column"><?php echo $correct_amounts[$i] ?></td>
            <td class="column"><?php echo $correct_amounts[$i]*$row['price'] ?></td>
        </tr>
    <?php
    $sum+=($correct_amounts[$i]*$row['price']);
}
echo "</table>";
echo "Suma: ".number_format((float)$sum, 2, '.', '')." zł"."<br>";
?>

<form method="post">
    <input type="hidden" name="sum" value="<?php echo $sum ?>">
    <input type="submit" name="clearBasket" value="Usuń wszystkie przedmioty" class="button">
    <input type="submit" name="checkout" value="Podsumowanie" class="button">
</form>

<?php
if(isset($_POST['clearBasket'])){
    $manager->clearBasket();
}
if(isset($_POST['checkout'])){
    $manager->clearBasket();
    for($i=0; $i<sizeof($items); $i++){
        $manager->addBasket($items[$i], $correct_amounts[$i], $correct_amounts[$i]);
    }
    $_SESSION['sum']=$sum;
    header('Location:checkout.php');
}
echo "</div>";
}
else{
    echo "Koszyk jest pusty";
}
?>

</body>
</html>