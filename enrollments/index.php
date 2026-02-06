<?php

include '../config/database.php';
include '../includes/functions.php';

$enrollments = getEnrollments($conn);
$i = 1;
?>

<h2>Enrollments List</h2>
<a href="create.php">Add New Enrollment</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Course Name</th>
        <th>Actions</th>
    </tr>
    <?php while ($enrollment = mysqli_fetch_assoc($enrollments)) {       
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $enrollment['student_name']; ?></td>
            <td><?php echo $enrollment['course_name']; ?></td>
            <td>
                <a href="delete.php?id=<?php echo $enrollment['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </table>
