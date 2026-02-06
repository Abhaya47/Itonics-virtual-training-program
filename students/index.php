<?php

include '../config/database.php';
include '../includes/functions.php';

$students = getStudents($conn); 

$i = 1;
?>

<h2>Students List</h2>
<a href="create.php">Add New Student</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php while ($student = mysqli_fetch_assoc($students)) {       
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['email']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $student['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $student['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </table>