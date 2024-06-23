<?php
session_start();
include_once "navbar.php";
$phrase = $_GET['searchphrase'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $phrase ?> - Aledrogo</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<?php
$db=new PDO("mysql:host=localhost;dbname=sklep", "root", "");
$sql=("SELECT id FROM Products WHERE name SOUNDS LIKE '$phrase%'");
try {
    $result=$db->query($sql);
}
catch(Exception $e){
    echo $e;
}
while($row=$result->fetch(PDO::FETCH_ASSOC)){
    $select[] = $row['id'];
}
?>
<div class="container">
<table>
<?php
$index = 0;
$rowsize = 4;
$length = ceil(sizeof($select)/4);
for($i = 0; $i<$length; $i++){
    if ($i==($length-1)){
        $rowsize = (sizeof($select)%4);
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
?>
</div>
</body>
</html>