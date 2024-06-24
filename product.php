<?php
session_start();
include_once "navbar.php";
include_once "db.php";
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
        <span>Cena: </span><br>
        <h2><?php echo $row['price'] ?> zł</h2>
        <form method="post">
            <input type="number" name="amount" value="1" placeholder="Ilość" class="amount" min="1" max="<?php echo $row['quantity'] ?>"><span> z <?php echo $row['quantity'] ?></span><br>
            <input type="submit" name="addtobasket" value="Dodaj do koszyka" class="button">
        </form>
    </div>
</div>
<div class="description">
    <h2>Opis: </h2><br>
    <p><?php echo $row['description']?></p>
</div>

<?php
//Dodawanie przedmiotu do koszyka
//if(isset($_POST['addtobasket'])){
//    addCookie('basketid', $id);
//    addCookie('basketquantity', $_POST['amount']);
//}

//Dodawanie przedmiotu do kolejki ostatnio przelądanych
addCookie("recent", $id);

//Funkcja która przypisuje wartości tablicy do ciasteczka
function addCookie($cookie_name, $value) {
    $arr = array();
    if(isset($_COOKIE[$cookie_name])){
        $data = $_COOKIE[$cookie_name];
        $arr = explode(";", $data);
    }

    if (!in_array($value, $arr))
    {
        if(sizeof($arr)>=4) {
            array_splice($arr, 0, 1);
        }
        $arr[] = $value;
    }
    $string = implode(";", $arr);

    //Ciasteczko ważne przez 1 godzinę
    setcookie($cookie_name, $string, time()+3600);
}

?>

</body>
</html>