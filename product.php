<?php
session_start();
include_once "navbar.php";
$id=$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aledrogo</title>
</head>
<body>

<?php
$db=new PDO("mysql:host=localhost;dbname=sklep", "root", "");
$sql=("SELECT * FROM Products WHERE id='$id'");
try {
    $result=$db->query($sql);
}
catch(Exception $e){
    echo $e;
}
?>
<table>
    <?php
    $row=$result->fetch(PDO::FETCH_ASSOC);
    echo "<img src='Products/$id' alt='$row[name]' width='500' height='500'>";
    echo $row['name'].$row['price']

    ?>
</table>

<?php

//Dodawanie przedmiotu do kolejki ostatnio przelądanych
$arr = array();
if(isset($_COOKIE['recent'])){
    $data = $_COOKIE['recent'];
    $arr = explode(";", $data);
}

if (!in_array($id, $arr))
{
    if(sizeof($arr)>=4) {
        array_splice($arr, 0, 1);
    }
    $arr[] = $id;
}
$string = implode(";", $arr);

//Ciasteczko ważne przez 1 godzinę
setcookie('recent', $string, time()+3600);
?>

</body>
</html>