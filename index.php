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

if(isset($_COOKIE['recent'])){
    $arr = array();
    $data = $_COOKIE['recent'];
    $arr = explode(";", $data);
    $select = array_merge($select, $arr);
}

echo "<table>";

$index = 0;
$rowsize = 4;
$length = ceil(sizeof($select)/4);
for($i = 0; $i<$length; $i++){
    if ($i==2){
        $rowsize = sizeof($arr);
        echo "</table>";
        echo "<h2>Ostatnio przeglądane przedmioty</h2>";
        echo "<table>";
    }
    echo "<tr>";
    for($j=0; $j<$rowsize; $j++){
        $sql=("SELECT name, price FROM Products WHERE id='$select[$index]'");
        try{
            $result = $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
        $row=$result->fetch(PDO::FETCH_ASSOC);
        echo "<td>
            <div class='product'>
                <a href='product.php?id=$select[$index]' class='link'><img src='Products/$select[$index]' class='productimg'></a>
                <div class='under'>
                    <a href='product.php?id=$select[$index]' class='link'>".$row['name']."</a>
                    <span class='price'>".$row['price']." zł"."</span>
                </div>
            </div>
        </td>";
        $index++;
    }
    echo "</tr>";
}
echo "</table>";
setcookie('recent', $_COOKIE['recent'], time()+3600);
?>
</div>

</body>
</html>