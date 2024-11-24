<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <script>
        function validatePassword() {
            var passwordInput = document.getElementById('password');
            if (isNaN(passwordInput.value)) {
                alert("Your Password is invalid, please enter a 5-digit number.");
                return false;
            }
            return true;
        }
    </script>

</head>
<body>

<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    $sql_student = "SELECT password FROM student WHERE password = '$password'";
    $result_student = $conn->query($sql_student);

    if ($result_student->num_rows > 0) {
        // Password exists in the student table
        echo "Password is correct. Redirecting to student_profile...";
        session_start();
        $_SESSION['student_password'] = $password;
        header("Location: student_profile.php");
        exit();
    } else {
        // Password does not exist in the student table, check in studentpass table
        $sql_studentpass = "SELECT password FROM studentpass WHERE password = '$password'";
        $result_studentpass = $conn->query($sql_studentpass);

        if ($result_studentpass->num_rows > 0) {
            // Password exists in the studentpass table
            echo "Password is correct. Redirecting to create_profile...";
            session_start();
            $_SESSION['student_password'] = $password;
            header("Location: create_profile.php");
            exit();
        } else {
            // Password does not exist in both student and studentpass tables
            echo "This password doesn't exist or is wrong.";
            echo "Error: " . $sql_student . "<br>" . $conn->error;
        }
    }
}

?>

    <h1>Student Login</h1>
    <form action="login.php" method="post" onsubmit="return validatePassword();">

        <label>Password:</label>
        <input type="password" id="password" name="password" required minlength="5" maxlength="5"/>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
