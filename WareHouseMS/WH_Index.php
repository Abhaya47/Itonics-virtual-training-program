<?php
include("config/warehousedb.php");

//Get List Of All WareHouse

$sql = "SELECT
A.WId As WareHouseId,
A.WName As WareHouseName,
A.Price As WareHousePrice,
B.CName As ClientName,
case when A.Status=0 THEN 'Available' else 'Occupied' END As Status

FROM `wh_warehouse` A
left outer join `wh_clients` B on A.WId=B.WId  ";
$result=mysqli_query($connection_string, $sql);
if(!$result){
    echo die(mysqli_error($connection_string));
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action']) && $_POST['action'] === "delete") {
    $WId = $_POST['wid'];
    mysqli_query($connection_string, "DELETE FROM wh_warehouse WHERE WId='$WId'");
}

mysqli_close($connection_string);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <div align="center" >
    <h2 align=center>WAREHOUSE LIST</h2> <br>
    <a href="http://localhost/Itonics/Itonics/WareHouseMS/WH_WareHouse.php"> <button >Add WareHouse</button></a>
    <a href="http://localhost/Itonics/Itonics/WareHouseMS/WH_Client.php"> <button >Add Client</button></a>
</div>
<?php
//checking the query result
$i=1;
if(mysqli_num_rows($result)> 0){  
    echo"<table border=2 padding=5 align=center>";
    echo"<tr>";
    echo"<th> S.N </th>";
    echo"<th> WareHouse Name </th>";
    echo"<th> WareHouse Price </th>";
    echo"<th> Client Name </th>";
    echo"<th> Status </th>";
    echo"</tr>";
// Iterating the list of warehoouse

while($row=mysqli_fetch_assoc($result)){
    echo"<tr>";
    echo"<td>  $i </td>";
    echo"<td>" .htmlspecialchars($row['WareHouseName']). "</td>";
    echo"<td>" .htmlspecialchars($row['WareHousePrice']). "</td>";
    echo"<td>" .htmlspecialchars($row['ClientName']). "</td>";
    echo"<td>" .htmlspecialchars($row['Status']). "</td>";
    echo"</tr>";
      // ACTION BUTTONS
        echo "<td align='center'>
                <form method='POST' action='WH_WareHouse.php' style='display:inline'>
                    <input type='hidden' name='wid' value='" . htmlspecialchars($row['WareHouseId']) . "'>
                    <input type='hidden' name='action' value='edit'>
                    <button type='submit'>Edit</button>
                </form>

                <form method='POST' action='WH_Index.php' style='display:inline'
                      onsubmit=\"return confirm('Are you sure you want to delete this warehouse?');\">
                    <input type='hidden' name='wid' value='" . htmlspecialchars($row['WareHouseId']) . "'>
                    <input type='hidden' name='action' value='delete'>

                    <button type='submit'>Delete</button>
                </form>
              </td>";

        echo "</tr>";

$i++;

}
    echo"</table";
}
else{
    echo"<h2 align=center>No WareHouse Found </h2>";
}
    ?>
</body>
</html>