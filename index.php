<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aledrogo</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php
session_start();
include_once "navbar.php";
?>

<div class="container">
<?php
$all = array();
$select = array();
$db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");
$sql = ("SELECT id FROM Products ORDER BY id");
try {
    $result = $db->query($sql);
}
catch (Exception $e){
    echo $e;
}
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $all[] = $row['id'];
}
for($i = 0; $i<8; $i++){
    $rand = rand(0, sizeof($all)-1);
    $select[] = $all[$rand];
    array_splice($all, $rand, 1);
}
echo "<table>";

$index=0;
$index2=0;
for($i = 0; $i<2; $i++){
    echo "<tr>";
    for($j=0; $j<4; $j++){
        echo "<td><a href='product.php?id=$select[$index]' class='link'><img src='Products/$select[$index]' width='300' height='300'></a></td>";
        $index++;
    }
    echo "</tr><tr>";
    for($j=0; $j<4; $j++){
        $sql=("SELECT name, price FROM Products WHERE id='$select[$index2]'");
        try{
            $result = $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
        $row=$result->fetch(PDO::FETCH_ASSOC);
        echo "<td><a href='product.php?id=$select[$index2]' class='link'>".$row['name']."</a><span class='price'>".$row['price']." zł"."</span></td>";
        $index2++;
    }
    echo "<tr>";
}
echo "</table>";
?>
</div>

</body>
</html>