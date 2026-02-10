<?php

// STUDENTS TABLE FUNCTIONS
function getStudents($conn) {
    return mysqli_query($conn, "SELECT * FROM students");
}

function getStudentById($conn, $id) {
    return mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
}

function addStudent($conn, $name, $email) {
    return mysqli_query($conn, "INSERT INTO students (name, email) VALUES ('$name', '$email')");
}

function updateStudent($conn, $id, $name, $email) {
    return mysqli_query($conn, "UPDATE students SET name = '$name', email = '$email' WHERE id = $id");
}

function deleteStudent($conn, $id) {
    return mysqli_query($conn, "DELETE FROM students WHERE id = $id");
}

// COURSES TABLE FUNCTIONS
function getCourses($conn) {
    return mysqli_query($conn, "SELECT * FROM courses");
}

function getCourseById($conn, $id) {
    return mysqli_query($conn, "SELECT * FROM courses WHERE id = $id");
}

function addCourse($conn, $name, $code) {
    return mysqli_query($conn, "INSERT INTO courses (name, code) VALUES ('$name', '$code')");
}

function updateCourse($conn, $id, $name, $code) {
    return mysqli_query($conn, "UPDATE courses SET name = '$name', code = '$code' WHERE id = $id");
}

function deleteCourse($conn, $id) {
    return mysqli_query($conn, "DELETE FROM courses WHERE id = $id");
}

// ENROLLMENTS TABLE FUNCTIONS
function getEnrollments($conn) {
    $sql = "SELECT enrollments.id, students.name AS student_name, courses.name AS course_name 
            FROM enrollments
            JOIN students on enrollments.student_id = students.id
            JOIN courses on enrollments.course_id = courses.id";
    return mysqli_query($conn, $sql);
}

function addEnrollment($conn, $student_id, $course_id) {
    return mysqli_query($conn, "INSERT INTO enrollments (student_id, course_id) VALUES ($student_id, $course_id)");
}
function deleteEnrollment($conn, $id) {
    return mysqli_query($conn, "DELETE FROM enrollments WHERE id = $id");
}