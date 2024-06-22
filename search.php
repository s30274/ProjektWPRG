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
    <link rel="stylesheet" href="search.css">
</head>
<body>

<?php
$db=new PDO("mysql:host=localhost;dbname=sklep", "root", "");
$sql=("SELECT id, name, price FROM Products WHERE name SOUNDS LIKE '$phrase'");
try {
    $result=$db->query($sql);
}
catch(Exception $e){
    echo $e;
}
?>
<div class="container">
<table>
<?php
while($row=$result->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td><a href='product.php?id=$row[id]'><img src='Products/$row[id]' width='200' height='200'></a></td><td class='table_name'><a href='product.php?id=$row[id]' class='link'>" .$row['name']."</a></td><td><span class='cena'>".$row['price']."</span></td></tr>";
}
?>
</table>
</div>
</body>
</html>