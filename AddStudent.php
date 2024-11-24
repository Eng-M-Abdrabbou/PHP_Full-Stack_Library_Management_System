<!DOCTYPE html>
<html>
<head>
    <title>Book Management</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<script>
function chkpassword() {
	
	var init = document.getElementById("1");
	var sec = document.getElementById("2");

	if(init.value ==""){
		alert ("You did not enter a password \n" + "Please enter one");
		
	return false;
	}
	
	if (init.value != sec.value)
	{
		
		alert("the two passwords are not the same \n"+ "please re-enter the passwords");
		return false;
	}
	
	else
		return true;
	
	
	
	
}
</script>

</head>
<body>

<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass = $_POST["pass"];


    $sql = "INSERT INTO studentpass (Password) 
            VALUES ('$pass')";

    if ($conn->query($sql) === TRUE) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    header("Location: LibrarianPage.php");
}
?>


    <h1>Book Management (Librarian)</h1>
    <form id="form" action="AddStudent.php" method="post">
        <label>Set Password:</label>
        <input type="password" id="1" name="pass" required minlength="5" maxlength="5">
		<label>Confirm Password:</label>
		<input type="password" id="2" name="pass" required minlength="5" maxlength="5">
        <br/>
        <input type="submit" value="Add Student">
    </form>
	<script>
document.getElementById("1").onblur =chkpassword;
document.getElementById("form").onsubmit =chkpassword;
	</script>
</body>
</html>
