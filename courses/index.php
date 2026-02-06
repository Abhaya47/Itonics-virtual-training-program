<?php

include '../config/database.php';
include '../includes/functions.php';

$courses = getCourses($conn);
$i = 1;
?>
<h2>Courses List</h2>
<a href="create.php">Add New Course</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Code</th>
        <th>Actions</th>
    </tr>
    <?php while ($course = mysqli_fetch_assoc($courses)) {       
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $course['name']; ?></td>
            <td><?php echo $course['code']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $course['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $course['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </table>