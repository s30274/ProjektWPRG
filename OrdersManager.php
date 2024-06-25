<?php
include_once "db.php";

trait OrdersManager {

    public function showOrders()
    {
        global $db;
        $sql = "SELECT * FROM Orders WHERE $this->id";
        try {
            $result = $db->query($sql);
        } catch (Exception $e) {
            print $e;
        }
        echo "<div class='container'><table>";
        while($row=$result->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><td>".$row['city']."</td><td>".$row['postcode']."</td><td>".$row['address']."</td><td>".$row['sum']."</td><td>".$row['date']."</td><td>".$row['done']."</td>";
            if(static::class=="Seller"){
                if($row['done']==0){
                    ?>
                    <td>
                    <form method="post">
                        <input type="hidden" name="orderid" value="<?php echo $row['id'] ?>">
                        <input type="submit" name="changestatus" value="Zrealizowane">
                    </form>
                    </td>
                    <?php
                }
            }
            echo "</tr>";
        }
        echo "</table></div>";

        if(isset($_POST['changestatus'])){
            $sql=("UPDATE Orders
            SET done='1'
            WHERE id='$_POST[orderid]'");
            try{
                $db->query($sql);
            } catch(Exception $e){
                echo $e;
            }
        }
    }
}