<?php
include("config/warehousedb.php");

$WId = "";
$WName = "";
$WPrice = "";
$WStatus = "0";

//Handle Editload
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action']) && $_POST['action'] === "edit") {

    $WId = $_POST['wid'];

    $sql = "SELECT 'WName','Price','Status' FROM wh_warehouse WHERE WId = '$WId'";
    $result = mysqli_query($connection_string, $sql);
    $row = mysqli_fetch_assoc($result);

    $WName = $row['WName'];
    $WPrice = $row['Price'];
    $WStatus = $row['Status'];
}

//handle save(insert/updt)
if ($_SERVER['REQUEST_METHOD'] === "POST" && !isset($_POST['action'])) {

    $WId     = $_POST['wid'] ?? "";
    $WName   = $_POST["warehousename"];
    $WPrice  = $_POST["price"];
    $WStatus = $_POST["status"];

    // INSERT
    if ($WId === "") {

        $WId = bin2hex(random_bytes(25));

        $sql = "
        INSERT INTO wh_warehouse
        VALUES ('$WId', '$WName', '$WPrice', '$WStatus')
        ";

        $msg = mysqli_query($connection_string, $sql)
            ? "Warehouse Successfully Added"
            : "Unable To Add Warehouse: " . mysqli_error($connection_string);
    }
    // UPDATE
    else {

        $sql = "
        UPDATE wh_warehouse
        SET
            WName = '$WName',
            Price = '$WPrice',
            Status = '$WStatus'
        WHERE WId = '$WId'
        ";

        $msg = mysqli_query($connection_string, $sql)
            ? "Warehouse Successfully Updated"
            : "Unable To Update Warehouse: " . mysqli_error($connection_string);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warehouse</title>
</head>
<body>

<a href="WH_index.php">
    <button>Home</button>
</a>

<h2><?php echo $WId ? "Edit Warehouse" : "Add Warehouse"; ?></h2>

<?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

<form method="POST">

    <!--Passing Wid for updating record-->
    <input type="hidden" name="wid" value="<?php echo htmlspecialchars($WId); ?>">

    <label>Warehouse Name</label><br>
    <input type="text" name="warehousename"
           value="<?php echo htmlspecialchars($WName); ?>" required><br><br>

    <label>Warehouse Price</label><br>
    <input type="number" step="0.01" name="price"
           value="<?php echo htmlspecialchars($WPrice); ?>" required><br><br>

    <label>Warehouse Status</label><br>
    <select name="status">
        <option value="0" <?php if ($WStatus == "0") echo "selected"; ?>>Available</option>
        <option value="1" <?php if ($WStatus == "1") echo "selected"; ?>>Occupied</option>
    </select><br><br>

    <input type="submit" value="Save">
</form>

</body>
</html>
