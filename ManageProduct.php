<?php

trait ManageProduct {
    public function addProduct($name, $price, $quantity, $description, $seller_id) {
        $db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");
        $sql = ("INSERT INTO Products(name, price, quantity, description, Seller_id) VALUES ('$name', '$price', '$quantity', '$description', '$seller_id')");
        try{
            $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function removeProduct($id) {
        $db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");
        $sql = ("DELETE FROM Products WHERE id='$id'
        ");
        try{
            $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function updateProduct($id, $name, $price, $quantity, $description, $sellerid) {
        $db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");
        $sql = ("UPDATE Products
        SET name='$name', price='$price', quantity='$quantity', description='$description', Seller_id='$sellerid'
        WHERE id='$id'
        ");
        try{
            $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
    }

    public function showManager() {
        //Połączenie z bazą danych
        $db = new PDO("mysql:host=localhost;dbname=sklep", "root", "");

        //Dane do formularza aktualizowania produktu
        $arr=array("", "", "", "", "add", "Dodaj produkt");
        if(isset($_POST['edit'])){
            $sql=("SELECT * FROM Products WHERE id='$_SESSION[editid]'");
            try{
                $result=$db->query($sql);
            }
            catch(Exception $e){
                echo $e;
            }
            $row=$result->fetch(PDO::FETCH_ASSOC);
            $arr=array($row['name'], $row['price'], $row['quantity'], $row['description'], "update", "Aktualizuj produkt");
            $sellerid=$row['Seller_id'];
        }

        //Formularz dodawania/aktualizowania produktu
        ?>
        <form method="post">
            <input type='text' name='name' placeholder='Nazwa produktu' value='<?php echo $arr[0] ?>'>
            <input type='text' name='price' placeholder='Cena' value='<?php echo $arr[1] ?>'>
            <input type='number' name='quantity' placeholder='Ilość' value='<?php echo $arr[2] ?>'>
            <textarea name='description' placeholder='Opis'><?php echo $arr[3] ?></textarea>
        <?php
        if(static::class=="Admin" && isset($_POST['edit'])) {
            $sql = "SELECT * FROM Users WHERE type LIKE 'seller'";
            try {
                $result = $db->query($sql);
            } catch (Exception $e) {
                print $e;
            }
            echo "<select name='sellerid'>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if (isset($sellerid) && $sellerid == $row['id']) {
                    echo "<option value=" . $row['id'] . " selected>" . $row['username'] . "</option>";
                } else {
                    echo "<option value=" . $row['id'] . ">" . $row['username'] . "</option>";
                }
            }
            echo "</select>";
        } else {
            echo "<input type='hidden' name='sellerid' value='$this->id'>";
        }
        ?>
            <input type='submit' name='<?php echo $arr[4] ?>' value='<?php echo $arr[5] ?>'>
        </form>
        <?php

        //Aktualizowanie danych
        if(isset($_POST['update'])){
            $this->updateProduct($_SESSION['editid'], $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['sellerid']);
        }

        //Dodawanie danych
        if(isset($_POST['add'])){
            $this->addProduct($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['sellerid']);
        }

        //Wyświetlanie danych produktu i przyciski do edytowania i usuwania produktów
        if(static::class=="Admin") {
            $sql = ("SELECT * FROM Products");
        } else {
            $sql = ("SELECT * FROM Products WHERE Seller_id='$this->id'");
        }
        try{
            $result=$db->query($sql);
        }
        catch(Exception $e){
            echo $e;
        }
        echo "<table>";
        echo "<tr><th>id</th><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Opis</th><th>id Sprzedawcy</th><th>Action</th></tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['price']."</td><td>".$row['quantity']."</td><td>".$row['description']."</td><td>".$row['Seller_id']."</td>";
            ?>
            <td>
                <form method='post'>
                    <input type='hidden' name='id' value='<?php echo $row['id'] ?>'>
                    <input type='submit' name='delete' class='button' value='Usuń'>
                    <input type='submit' name='edit' class='button' value='Edytuj'>
                </form>
            </td>
            <?php
            echo "</tr>";
        }
        echo "</table>";

        //Przekazanie który produkt ma być edytowany
        if(isset($_POST['edit'])){
            $_SESSION['editid']=$_POST['id'];
        }

        //Usunięcie produktu
        if(isset($_POST['delete'])){
            $deleteid=$_POST['id'];
            $sql=("DELETE FROM Products WHERE id='$deleteid'");
            $good=true;
            try{
                $db->query($sql);
            }
            catch(Exception $e){
                echo $e;
                $good = false;
            }
            if($good){
                echo "Succesfully deleted product with id = ".$deleteid;
            }
        }
    }
}