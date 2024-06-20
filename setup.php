<?php
$db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");

//$nuke=("START TRANSACTION;
//    DROP TABLE Items;
//    DROP TABLE Orders;
//    DROP TABLE Products;
//    DROP TABLE Users;
//COMMIT;");
//
//try{
//    $db->query($nuke);
//}
//catch (Exception $e){
//    echo $e;
//}

$sql=("CREATE TABLE IF NOT EXISTS Users(
id int PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(32) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
active BOOL DEFAULT 0,
code VARCHAR(6) NOT NULL,
type ENUM('user', 'seller', 'admin')
)");
try{
    $db->query($sql);
}
catch (Exception $e){
    echo $e;
}

$sql=("CREATE TABLE IF NOT EXISTS Products(
id int PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(32) NOT NULL,
price DECIMAL(7, 2) NOT NULL,
quantity INT NOT NULL,
description MEDIUMTEXT NOT NULL,
Seller_id INT NOT NULL,
FOREIGN KEY (Seller_id) REFERENCES Users(id)
)");
try{
    $db->query($sql);
}
catch (Exception $e){
    echo $e;
}

$sql=("CREATE TABLE IF NOT EXISTS Orders(
id int PRIMARY KEY AUTO_INCREMENT,
city VARCHAR(255) NOT NULL,
postcode VARCHAR(5) NOT NULL,
address VARCHAR(255) NOT NULL,
sum float NOT NULL,
date date NOT NULL,
done bool DEFAULT 0,
User_id INT NOT NULL,
FOREIGN KEY (User_id) REFERENCES Users(id)
)");
try{
    $db->query($sql);
}
catch (Exception $e){
    echo $e;
}

$sql=("CREATE TABLE IF NOT EXISTS Items(
id int PRIMARY KEY AUTO_INCREMENT,
quantity INT NOT NULL,
Product_id INT NOT NULL,
Order_id INT NOT NULL,
FOREIGN KEY (Product_id) REFERENCES Products(id),
FOREIGN KEY (Order_id) REFERENCES Orders(id)
)");
try{
    $db->query($sql);
}
catch (Exception $e) {
    echo $e;
}

//TEMPTORARY admin account
$sql=("
INSERT INTO Users(username, email, password, active, code, type) VALUES ('admin', 's30274@pjwstk.edu.pl', '$2y$10$7K/L4N.4MIB0v7Ab0Jj.K.FVhwzBfxBcIXKddz6OzkiLcKXpDXuai', 1, '435723', 'admin')
");
try{
    $db->query($sql);
}
catch(Exception $e){
    echo $e;
}