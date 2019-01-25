<?php
$servername = "mycolvps";
$username = "root";
$password = "";
$dbname = "fcm_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection


$sql = "SELECT * FROM score";
$result = $conn->query($sql);


//Before the for each
$encoded_msg = '{
  "movies": [';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "msg: " . $row["msg"]. " - event: " . $row["event"]. " " . "</br>";
	
//JSON encode here
	
$encoded_msg .= '{ ' 
	. '"movie": "' .$row["date"] . '",'  
	. '"year":  "' .$row["score"] . '"'  
	.' },';


//$row["msg"].$row["event"];

}
} else {
    echo "0 results";
}
//After the foreach

$encoded_msg = substr($encoded_msg, 0, -1);
$encoded_msg .= '  ]
}';
echo $encoded_msg;
$conn->close();
?>
