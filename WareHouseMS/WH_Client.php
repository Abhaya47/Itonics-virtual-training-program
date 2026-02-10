<?php
include("config/warehousedb.php");

//Clients

//Save Clients
$ClientId=bin2hex(random_bytes(25));
$ClientName=$_POST["CName"];
$ClientAddress=$_POST["CAddress"];
$ClientDOE=$_POST["Date"];
$WareHouse=$_POST["warehouse"];

$sql2= "SELECT A.WId As Id ,A.WName As Name FROM `wh_warehouse` A WHERE A.Status='0';";
$result2=mysqli_query($connection_string,$sql2);


if ($_SERVER['REQUEST_METHOD']=== "POST"){
$sql = "INSERT INTO `wh_clients` 
VALUES ('$ClientId','$WareHouse', '$ClientName', '$ClientAddress', '$ClientDOE');";
$result=mysqli_query($connection_string, $sql);
if($result >0){
    $updatesql="Update wh_warehouse A Set A.Status=1 where A.WId='$WareHouse';";
    mysqli_query($connection_string,$updatesql);
    echo"Client Successfully Added";
}
else{
    echo "Unable To Add Client";
}
mysqli_close($connection_string);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="http://localhost/Itonics/Itonics/WareHouseMS/WH_index.php" ><button>Home</button></a>

     <h2>Add Client</h2>
    <form action="WH_Client.php" method="post">
    <label>CLient Name</label>
    <input type="text" name="CName" required><br>
    <label>CLient Address</label>
    <input type="text" name="CAddress"><br>
    <label>WareHouse Name</label>
    <select name="warehouse" id="warehouse" placeholder="--Select WareHouse--" >
=        <?php 
        while($row=mysqli_fetch_assoc($result2)){
            echo'<option value="'.htmlspecialchars($row['Id']).'">'
            .htmlspecialchars($row['Name']).'</option>';
        }

        ?>
    </select>
    <br>

    <label>Date Of Expiry</label>
    <input type="date" name="Date" required><br>
    <input type="submit" name="submit">
    </form>
</body>
</html>