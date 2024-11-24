<?php
include 'db.php';  // Include your database connection file

session_start();
if (!isset($_SESSION['student_password'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $major = $_POST['major'];
        $studentId = $_POST['student_id'];  // Get student ID from the session
		$password = $_SESSION['student_password'];

        $sql = "INSERT INTO student (name, major, student_id, password) 
                VALUES ('$name', '$major', '$studentId' , '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Profile created successfully!";
			session_start();
			$_SESSION['student_password'] = $password;
			header("Location: student_profile.php");
			
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Create Your Profile</h2>

    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="major">Major:</label>
        <input type="text" name="major" required><br>

        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required><br>

        <input type="submit" name="submit" value="Create Profile">
    </form>
</body>
</html>