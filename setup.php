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
username varchar(32) NOT NULL,
email varchar(255) NOT NULL,
password varchar(255) NOT NULL,
active bool DEFAULT 0,
code varchar(6) NOT NULL,
type enum('user', 'seller', 'admin')
)");
try{
    $db->query($sql);
}
catch (Exception $e){
    echo $e;
}

$sql=("CREATE TABLE IF NOT EXISTS Products(
id int PRIMARY KEY AUTO_INCREMENT,
name varchar(32) NOT NULL,
price int NOT NULL,
quantity int NOT NULL,
description mediumtext NOT NULL,
Seller_id int NOT NULL,
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
date date NOT NULL,
done bool DEFAULT 0,
User_id int NOT NULL,
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
quantity int NOT NULL,
Product_id int NOT NULL,
Order_id int NOT NULL,
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