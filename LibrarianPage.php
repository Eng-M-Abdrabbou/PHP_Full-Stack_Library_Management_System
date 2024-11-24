<?php
//this is LibrarianPage.php
//include 'CreateDB.php';  // To Include the php code for making the database and table

include 'db.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Librarian Page</h1>
	
	<table>
   <tr> <td> <a href="AddBook.php">Add a Book</a>  </td> </tr>
   <tr> <td>  </td> </tr>
   <tr> <td> <a href="AddStudent.php">Add a Student</a> </td> </tr>
    </table>

   
   <form method="post" action="LibrarianPage.php">
 <label> update book status <input type="number" name="bookid";> </label>
 <input type="submit" name="updatestatus" value="Update Book Status">
</form>

<h1>All Books in the library</h1>
<?php 

$query = "SELECT * FROM books;";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) >= 1) {
    // Table header
    echo "<table>";
    echo "<tr><th>Book ID</th><th>Book Name</th><th>Book Version</th><th>Book Publisher</th><th>Publication Year</th><th>Book Field</th><th>Book Borrowed</th></tr>";

    while ($row = mysqli_fetch_array($result)) {
        // Table data for each record
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
        echo "<td>" . $row[4] . "</td>";
        echo "<td>" . $row[5] . "</td>";
		echo "<td>" . $row[6] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "There are no books in the library. Please add books to the database.";
}


if(isset($_POST["updatestatus"])){
	$id=$_POST["bookid"];
	$queryCheck="select status from books WHERE id ='".$id."'";
	$stmt = $conn->prepare($queryCheck);
    $stmt->execute();
    $result4 = $stmt->get_result();
	$row = $result4->fetch_assoc();
    $stat=$row['status'];

	if($stat=='false'){
	$query9="UPDATE books SET status='true' WHERE id ='$id';"; }
	else{
	$query9="UPDATE books SET status='false' WHERE id ='$id';";
	}
	
	// echo $query9;
	if(mysqli_query($conn, $query9)) 	
	{echo "<br/>The Book status has been updated Successfully <br/>"; } 	
	else 
{echo "Updating Book Status Failed, if the id you input is valid, connection to the database failed"; } }

?>
	
	

</body>
</html>
