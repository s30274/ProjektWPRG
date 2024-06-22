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
    echo "<img src='Products/$id' width='500' height='500'>";
    echo $row['name'].$row['price']
    ?>


</body>
</html>