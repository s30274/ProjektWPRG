<?php
session_start();
include_once "navbar.php";
include_once "db.php";
include_once "CookieManager.php";
if(!isset($_GET['id'])){
    header("Location: index.php");
} else {
    $id=$_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aledrogo</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>

<?php
global $db;
//Wczytanie informacji o produkcie
$sql=("SELECT * FROM Products WHERE id='$id'");
try {
    $result=$db->query($sql);
}
catch(Exception $e){
    echo $e;
}

//Wyświetlanie informacji o produkcie
$row=$result->fetch(PDO::FETCH_ASSOC);
?>
<div class="info_container">
    <div class="image">
        <img src='Products/<?php echo $id ?>' alt='<?php echo $row['name'] ?>' class="imageimg">
    </div>
    <div class="name">
        <h1><?php echo $row['name'] ?></h1>
    </div>
    <div class="price">
        <?php
        if($row['quantity']>0){
        ?>
        <span>Cena: </span><br>
        <h2><?php echo $row['price'] ?> zł</h2>
        <form method="post">
            <input type="number" name="amount" value="1" placeholder="Ilość" class="amount" min="1" max="<?php echo $row['quantity'] ?>"><span> z <?php echo $row['quantity'] ?></span><br>
            <input type="submit" name="addtobasket" value="Dodaj do koszyka" class="button">
        </form>
        <?php
        }
        else {
            echo "<span>Produkt wyprzedany</span>";
        }
        ?>
    </div>
</div>
<div class="description">
    <h2>Opis: </h2><br>
    <p><?php echo $row['description']?></p>
</div>

<?php
$manager = new CookieManager();
//Dodawanie przedmiotu do koszyka
if(isset($_POST['addtobasket'])){
    $manager->addBasket($id, $_POST['amount'], $row['quantity']);
}

//Dodawanie przedmiotu do kolejki ostatnio przelądanych
$manager->addRecent($id);
?>

</body>
</html>