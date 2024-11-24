<!DOCTYPE html>
<html>
<head>
    <title>Book Management</title>
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>

<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $version = $_POST["version"];
    $publisher = $_POST["publisher"];
    $publicationYear = $_POST["publicationYear"];
    $field = $_POST["field"];
    $status = $_POST["status"];


    $sql = "INSERT INTO books (title, version, publisher, publication_year, field, status) 
            VALUES ('$title', '$version', '$publisher', '$publicationYear', '$field', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Book added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    header("Location: LibrarianPage.php");
}
?>


    <h1>Book Management (Librarian)</h1>
    <form action="AddBook.php" method="post">
        <label>Title:</label>
        <input type="text" id="title" name="title" required maxlength="50">
        <br/>
        <label>Version:</label>
        <input type="number" id="version" name="version" required maxlength="20">
        <br/>
        <label>Publisher:</label>
        <input type="text" id="publisher" name="publisher" required maxlength="50">
        <br/>
        <label>Publication Year:</label>
        <input type="range" id="publicationYear" value="2000" name="publicationYear" required min="1000" max="3000" oninput="this.nextElementSibling.value = this.value">
			<output></output>
        <br/>
        <label>Field:</label>
        <input type="text" id="field" name="field" required maxlength="50">
        <br/>
        <label>Status:</label>
        <select id="status" name="status">
            <option value="false">On the Shelf</option>
            <option value="true">Borrowed</option>
        </select>
        <br>
        <input type="submit" value="Add Book">
    </form>
</body>
</html>
