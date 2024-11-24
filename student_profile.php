<?php
include 'db.php';

session_start();
if (!isset($_SESSION['student_password'])) {
    header('Location: login.php');
    exit();
}

$password = $_SESSION['student_password'];

$result1= mysqli_query($conn,"select name from student where password = '$password';");
if ($result1) {
    $row = $result1->fetch_assoc();
$name = $row['name']; }
$result2= mysqli_query($conn,"select major from student where password = '$password';"); 
if ($result2) {
    $row = $result2->fetch_assoc();
$major = $row['major']; }
$result3= mysqli_query($conn,"select student_id from student where password = '$password';");
if ($result3) {
    $row = $result3->fetch_assoc();
$id = $row['student_id']; }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<style>

</style>
</head>
<body class="profile">
    <h2>Welcome, <?php echo $name; ?>!</h2>

    <h3>Your Information:</h3>
    <p>Your student id is: <?php echo $id; ?></p>
    <p>Your Major is: <?php echo $major; ?></p>



<h2>Books available to borrow</h2>


<?php
/*
$query = "select * from books where status = 'false';";
// status false means not borrowed, else means borrowed
$result = mysqli_query($conn, $query) ;
if ( mysqli_num_rows($result)>= 1){
While ($row = mysqli_fetch_array($result))
echo "<tr>". "The book id is:  ". $row[0] . "&nbsp &nbsp" ."The book name is:  ". $row[1]. "&nbsp &nbsp" ."The book version is:  " .$row[2]. "&nbsp &nbsp"."The book publisher is:  " .$row[3]. "&nbsp &nbsp"."The book publication year is:  " .$row[4]. "&nbsp &nbsp"."The book field is: " .$row[5]. "</tr>". "<br/>"; 
}else
{
	echo"there are no books available to borrow, all books are borrowed";
}
*/
$query = "SELECT * FROM books WHERE status = 'false';";
// status false means not borrowed, else means borrowed
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) >= 1) {
    // Table header
    echo "<table>";
    echo "<tr><th>Book ID</th><th>Book Name</th><th>Book Version</th><th>Book Publisher</th><th>Publication Year</th><th>Book Field</th></tr>";

    while ($row = mysqli_fetch_array($result)) {
        // Table data for each record
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
        echo "<td>" . $row[4] . "</td>";
        echo "<td>" . $row[5] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "There are no books available to borrow. All books are borrowed.";
}

?>

 <h2>Borrow a Book:</h2>
 <form method="post">
 <input type = "submit" name ="borrow" value = "borrow a book" />
 <br/>  <br/>
 </form>
 <?php

if (isset($_POST["borrow"])){	
$query10 = "SELECT COUNT(*) AS numBorrowed FROM borrowed WHERE password = ?";
$stmt1 = $conn->prepare($query10);
$stmt1->bind_param("s", $password);
$stmt1->execute();
$result2 = $stmt1->get_result();
$row = $result2->fetch_assoc();
$numBorrowed = $row['numBorrowed'];

$query = "select * from books where status = 'false';"; 
$result = mysqli_query($conn, $query) ;
if ($result->num_rows > 0) {

   // Check if the student can borrow more books
    if ($numBorrowed < 3) {
	if ( mysqli_num_rows($result)> 0){
echo"
<form method = 'post' action='student_profile.php'>
<table>
<h3> Type the id of the book you want to borrow </h3>  <br/>  <br/>
<h4> Books still available to borrow </h4>
";
/*
While($row = mysqli_fetch_array($result)){
echo" The book id is: ".$row[0]."&nbsp  <br/> &nbsp"."The book name is: ".$row[1]."&nbsp &nbsp"."<br/>";}*/
while ($row = mysqli_fetch_array($result)) {
	echo "<table>";
    echo "<tr><th>Book ID</th><th>Book Name</th></tr>";
    echo "<tr>";
    echo "<td>" . $row[0] . "</td>";
    echo "<td>" . $row[1] . "</td>";
    echo "</tr>";
	echo "<table>";
}
echo"
<tr>
<input type ='text' name ='Booksid' required minlength='1' maxlength='5'/>
</tr> 
 <br/>  <br/>
<input type='submit' name='go' value='go'/>
</table>
</form>
";} else{
echo "There are no books left to borrow and you have borrowed more than three books, you can't borrow more";		
}} else{echo"you have borrowed more than three books, you can't borrow more";}
}
else{
echo "There are no books left to borrow";} 

}

	if(isset($_POST["go"])){
	$id=$_POST["Booksid"];	
	$queryCheck="select status from books WHERE id ='".$id."'";
	$stmt = $conn->prepare($queryCheck);
    $stmt->execute();
    $result4 = $stmt->get_result();
	$row = $result4->fetch_assoc();
    $stat=$row['status'];

	if($stat=='false'){
	$currentDate = date("Y-m-d");
	$id=$_POST["Booksid"];
	$query1= "insert into borrowed (password ,bookID, borrowDate) value ('$password','$id','$currentDate');";
	$result1 = mysqli_query($conn, $query1);
	
	$query2="UPDATE books SET status='true' WHERE id ='".$id."'"; 
	if(mysqli_query($conn, $query2)) 	
	{echo "<br/>The Book status has been updated Successfully"; } 	
	else 
	{echo "Updating Book Status Failed"; } 
	if($result1){
	echo"<br/>The book has been borrowed succesfully";
	}}else{
		
		echo "this books has been borrowed already, please choose a book from the available books displayed.";
	}
	
	}
	
	
?>
	
		
	
 <h2>Your Borrowed Books:</h2>

<?php



$query = "SELECT student.name, books.title, borrowed.borrowDate
          FROM student
          JOIN borrowed ON student.password = borrowed.password
          JOIN books ON borrowed.bookID = books.id
          WHERE student.password='$password';";
$result = mysqli_query($conn, $query);

$numRows = mysqli_num_rows($result);
echo "<table>";
if ($numRows > 0) {
    // Table header
    echo "<tr><th>Borrower</th><th>Book Title</th><th>Borrow Date</th><th>Remaining Days to Return</th></tr>";

    while ($row = mysqli_fetch_array($result)) {
        $borrowDate = $row['borrowDate'];
        $currentDate = date("Y-m-d");
        $daysRemaining = 120 - floor((strtotime($currentDate) - strtotime($borrowDate)) / (60 * 60 * 24));

        // Table data for each record
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['borrowDate'] . "</td>";
        echo "<td>" . $daysRemaining . " days</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "You didn't borrow any books";
}












?>

<h2>Return a borrowed Book:</h2>
<form method="post">
    <label for="returnBookId">Book ID:</label>
    <input type="text" name="returnBookId" required minlength="1" maxlength="5" /> <br/>
    <input type="submit" name="return" value="return a book" />
</form>

<?php
if (isset($_POST["return"])) {
    $returnBookId = $_POST["returnBookId"];

		$query1 = "SELECT * FROM borrowed WHERE password = ? AND bookID = ?";
		$result1 = $conn->prepare($query1);
		$result1->bind_param("si", $password, $returnBookId);
		$result1->execute();
		$resultquery1 = $result1->get_result();

    if ($resultquery1->num_rows > 0) {
        $query2 = "SELECT borrowDate FROM borrowed WHERE password = ? AND bookID = ?";
        $result2 = $conn->prepare($query2);
        $result2->bind_param("si", $password, $returnBookId);
        $result2->execute();
        $resultquery2 = $result2->get_result();
        $rowReturnDate = $resultquery2->fetch_assoc();
        $returnDate = $rowReturnDate['borrowDate'];

        $currentDate = date("Y-m-d");
        $extradays = strtotime($currentDate) - strtotime($returnDate);
        $extradays = floor($extradays / (60 * 60 * 24));
        if ($extradays > 120) {
            $chargeAmount = ($extradays - 120) * 50;

            $queryInsertCharge = "INSERT INTO charges (student_password, book_id, return_date, charge_amount) VALUES (?, ?, ?, ?)";
			$stmtInsertCharge = $conn->prepare($queryInsertCharge);
			$stmtInsertCharge->bind_param("sisd", $password, $returnBookId, $currentDate, $chargeAmount);
			$stmtInsertCharge->execute();

			$queryUpdateBorrowed = "DELETE FROM borrowed WHERE password = ? AND bookID = ?";
			$stmtUpdateBorrowed = $conn->prepare($queryUpdateBorrowed);
			$stmtUpdateBorrowed->bind_param("si", $password, $returnBookId);
			$stmtUpdateBorrowed->execute();


            echo "Book returned successfully. Charges: $chargeAmount AED";
        } else {
            // Update the borrowed table (mark book as returned)
            $queryUpdateBorrowed = "DELETE FROM borrowed WHERE password = ? AND bookID = ?";
            $stmtUpdateBorrowed = $conn->prepare($queryUpdateBorrowed);
            $stmtUpdateBorrowed->bind_param("si", $password, $returnBookId);
            $stmtUpdateBorrowed->execute();
			
			$query9="UPDATE books SET status='false' WHERE id ='$returnBookId';"; 
	if(mysqli_query($conn, $query9)) 	
	{echo "<br/>The Book status has been updated Successfully <br/>"; } 	
	else 
	{echo "Updating Book Status Failed"; } 

            echo "Book returned successfully. No charges.";
        }
    } else {
        echo "<br/> You did not borrow this book.";
    }
}

?>
<br/><br/>
    <a href="index.php">Logout</a>
</body>
</html>
