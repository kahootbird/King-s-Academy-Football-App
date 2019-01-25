<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  






<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Event: <input type="date" name="Event" value="">
  <br><br>
  Title: <input type="text" name="Title" value="">
  
<input type="submit" name="submit" value="Submit">  
</form>

Your input: </br>
Event:
<?php echo htmlspecialchars($_POST['Event']); ?>
</br></br>
Title:
<?php echo htmlspecialchars($_POST['Title']); ?>

<?php
$Event = htmlspecialchars($_POST['Event']);
$Title = htmlspecialchars($_POST['Title']);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fcm_db";
/*
INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";
*/
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO events (event, msg) VALUES ('$Event', '$Title')"; 


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

echo '</br></br></br> Event: ';
echo $Event;
?>

</body>
</html>

