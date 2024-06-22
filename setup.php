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
INSERT INTO Users(username, email, password, active, code, type) VALUES ('admin', 'admin', '$2y$10$7K/L4N.4MIB0v7Ab0Jj.K.FVhwzBfxBcIXKddz6OzkiLcKXpDXuai', 1, '435723', 'admin');
INSERT INTO Users(username, email, password, active, code, type) VALUES ('biokomponenty', 'biokomponenty@gmail.com', '$2y$10$43u84Fm8PTNXNq.DPoWXHeLDSpnMMC7bUTe0CtcEqkjSPAE5Okbg.', 1, '925341', 'seller');
INSERT INTO Users(username, email, password, active, code, type) VALUES ('komputery', 'komputery@gmail.com', '$2y$10$43u84Fm8PTNXNq.DPoWXHeLDSpnMMC7bUTe0CtcEqkjSPAE5Okbg.', 1, '983459', 'seller');
INSERT INTO Users(username, email, password, active, code, type) VALUES ('ubraniex', 'ubraniex@gmail.com', '$2y$10$43u84Fm8PTNXNq.DPoWXHeLDSpnMMC7bUTe0CtcEqkjSPAE5Okbg.', 1, '342534', 'seller');
");
try{
    $db->query($sql);
}
catch(Exception $e){
    echo $e;
}

$sql=("
    INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Woda', 2.5, 30, 'Woda źródlana 1.5 litra', 2);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Komputer', 2000, 5, 'Szybki komputer dysk 1000 grafika gtx', 3);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Monitor', 400, 7, 'Monitor 21 cali, matryca lcd', 3);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Laptop', 3000, 2, 'Laptop do biura 16GB RAM', 3);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Mąka', 3.75, 50, 'Mąka pszenna 1kg', 2);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Bluza', 100, 5, 'Czarna bluza z kapturem', 4);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Koszulka', 40, 10, 'Czarna koszulka', 4);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Jajco', 0.9, 48, 'Jedno jajco', 2);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Koszulka', 40, 8, 'Czerwona koszulka', 4);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Kapibara', 200, 2, 'Jedna kapibara', 2);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Telefon', 57, 9, 'Telefon nokia, niezniszczalny', 3);
        INSERT INTO Products(name, price, quantity, description, seller_id) VALUES ('Madagaskar 2', 35, 1, 'Film na DVD Madagaskar 2', 3);
");

try{
    $db->query($sql);
}
catch (Exception $e){
    echo $e;
}