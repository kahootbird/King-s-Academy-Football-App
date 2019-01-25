<?php
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fcm_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT *, @counter := @counter + 1 AS 'counter' FROM notifications, (SELECT @counter := 0) r ORDER BY counter DESC";
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
	. '"movie": "' .addslashes(html_entity_decode($row["server_notification"],ENT_QUOTES)) . '",'  
	. '"year":  "' .addslashes(html_entity_decode($row["device_notification"],ENT_QUOTES)) . '"'  
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
