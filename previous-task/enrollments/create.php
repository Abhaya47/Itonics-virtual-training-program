<?php

include '../config/database.php';
include '../includes/functions.php';

$students = getStudents($conn);
$courses = getCourses($conn);

if (isset($_POST['enroll'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    addEnrollment($conn, $student_id, $course_id);
    header("Location: index.php");
}
?>

<h2>Enroll Student in Course</h2>
<form method="POST">
<label for="student_id">Select Student:</label><br>
<select id="student_id" name="student_id" required>
    <option value="">-- Select Student --</option>
    <?php foreach ($students as $student): ?>
        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
    <?php endforeach; ?>
</select><br><br>
<label for="course_id">Select Course:</label><br>
<select id="course_id" name="course_id" required>
    <option value="">-- Select Course --</option>   
    <?php foreach ($courses as $course): ?>
        <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
    <?php endforeach; ?> 
</select><br><br>
<input type="submit" name="enroll" value="Enroll Student">
</form>