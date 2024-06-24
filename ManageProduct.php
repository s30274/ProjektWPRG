<?php
include_once "db.php";
trait ManageProduct {
    public function addProduct($name, $price, $quantity, $description, $seller_id) {
        global $db;
        $sql = ("INSERT INTO Products(name, price, quantity, description, Seller_id) VALUES ('$name', '$price', '$quantity', '$description', '$seller_id')");
        try{
            $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
    }



    public function removeProduct($id) {
        global $db;
        $sql = ("DELETE FROM Products WHERE id='$id'
        ");
        $good=true;
        try{
            $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
            $good=false;
        }
        if($good){
            return true;
        } else{
            return false;
        }
    }



    public function updateProduct($id, $name, $price, $quantity, $description, $sellerid) {
        global $db;
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



    private function checkImage($image, $target_file) {
        $check = getimagesize($image["tmp_name"]);
        if($check !== false) {
            $uploadOk = true;
        } else {
            echo "Plik nie jest zdjęciem.";
            $uploadOk = false;
        }

        if (file_exists($target_file)) {
            unlink($target_file);
        }

        if ($image["size"] > 2048000) {
            echo "Plik jest za duży. Maksymalny rozmiar to 2MB.";
            $uploadOk = false;
        }

        if ($uploadOk) {
            return true;
        } else{
            return false;
        }
    }



    public function addImage($image) {
        global $db;
        $sql=("SELECT id FROM Products WHERE Seller_id='$_POST[sellerid]' ORDER BY id DESC LIMIT 1");
        try {
            $result = $db->query($sql);
        }
        catch (Exception $e){
            echo $e;
        }
        $row=$result->fetch(PDO::FETCH_ASSOC);
        $target_file = "./Products/".$row['id'];

        if($this->checkImage($image, $target_file)){
            if(move_uploaded_file($image["tmp_name"], $target_file)){
                echo "Plik ". htmlspecialchars( basename( $image["name"])). " został wysłany.";
            } else {
                echo "Wystąpił błąd.";
                $this->removeProduct($row['id']);
            }
        } else {
            $this->removeProduct($row['id']);
        }
    }



    public function updateImage($id, $image) {
        $target_file = "./Products/".$id;

        if ($this->checkImage($image, $target_file)) {
            if(move_uploaded_file($image["tmp_name"], $target_file)){
                echo "Plik ". htmlspecialchars( basename( $image["name"])). " został wysłany.";
                return true;
            } else {
                echo "Wystąpił błąd.";
                return false;
            }
        } else {
            return false;
        }
    }



    public function showManager() {
        //Połączenie z bazą danych

        //Dane do formularza aktualizowania produktu
        global $db;
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
        <form method="post" enctype="multipart/form-data">
            <input type='text' name='name' placeholder='Nazwa produktu' value='<?php echo $arr[0] ?>'>
            <input type="file" name="image" accept="image/*">
            <input type='text' name='price' placeholder='Cena' value='<?php echo $arr[1] ?>'>
            <input type='number' name='quantity' placeholder='Ilość' value='<?php echo $arr[2] ?>'>
            <textarea name='description' placeholder='Opis'><?php echo $arr[3] ?></textarea>
        <?php
        if(static::class=="Admin") {
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
            if($_FILES['image']['size'] != 0){
                if($this->updateImage($_SESSION['editid'], $_FILES['image'])){
                    $this->updateProduct($_SESSION['editid'], $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['sellerid']);
                }
            } else {
                $this->updateProduct($_SESSION['editid'], $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['sellerid']);
            }
        }

        //Dodawanie danych i tworzenie zdjęcia
        if(isset($_POST['add'])){
            if($_FILES['image']['size'] != 0) {
                $this->addProduct($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['description'], $_POST['sellerid']);
                $this->addImage($_FILES['image']);
            }
            else{
                echo "Nie wybrano zdjęcia";
            }
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
        echo "<br><br>";
        echo "<table>";
        echo "<tr><th>Zdjęcie</th><th>id</th><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Opis</th><th>id Sprzedawcy</th><th>Czynność</th></tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td><img src='Products/$row[id]' height='50' width='50'></td>";
            echo "<td>".$row['id']."</td><td>".$row['name']."</td><td>".$row['price']."</td><td>".$row['quantity']."</td><td>".$row['description']."</td><td>".$row['Seller_id']."</td>";
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
            if($this->removeProduct($deleteid)){
                echo "Usunięto produkt z id = ".$deleteid;
            }
        }
    }
}