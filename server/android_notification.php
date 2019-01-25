<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>King's Academy Football Webapp</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">King's Academy Football</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="fcmtest">Dashboard</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="dashboard.php">Main <span class="sr-only">(current)</span></a></li>
            <li><a href="app_notifications.php">App Notifications</a></li>
            <li class="active"><a href="android_notification.php">Android Instant Notifications</a></li>
	    <li><a href="team_schedule.php">Team Schedule</a></li>
	    <li><a href="team_events.php">Team Events</a></li>
         </ul>
         </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
            
          </div>

          <h2 class="sub-header">Android Instant Notifications</h2>

<?php
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

$delete_data = htmlspecialchars($_POST['delete_data'], ENT_QUOTES);
echo $delete_data;
$Event = escapeJsonString(htmlspecialchars($_POST['server_notification'],ENT_QUOTES));
echo $Event;
$Title = "";
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

$sql = "INSERT INTO notifications (server_notification, device_notification) VALUES ('$Event', '$Title')"; 

if ($Event != NULL)
{
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

if ($delete_data != null)
{

$sql = "delete from notifications where server_notification =  '" . $delete_data . "' OR device_notification = '" . $delete_data . "'"; 
$conn->query($sql);
}

$conn->close();

echo '</br></br></br>';
echo $Event;


?>

	<form method="post" action="send_notification.php">  
  Title:
<input type="text" class="form-control" name="title" maxlength="45" value="">
Event: 
  <input type="text" class="form-control" maxlength="45" name="message" value="">
  <br><br>

  
<input type="submit" name="submit" value="Submit">  
</form>







          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Notification</th>
                </tr>
              </thead>
              <tbody>
                



<?php

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM notifications";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "msg: " . $row["msg"]. " - event: " . $row["event"]. " " . "</br>";
	
//JSON encode here
	
$encoded_msg .= '<tr><td>' 
	.$row["server_notification"] . ""  
	.$row["device_notification"] . ""

	.'	<form method="post" action="/fcmtest/app_notifications.php">
<input type="hidden" name="delete_data" value="'  .$row["server_notification"] . ""  
	.$row["device_notification"] . "".'">  
<input type="submit" name="submit" value="Erase Data">  
</form>'

	.'</tr></td>'

;


}
} else {
 //   echo "No Data";
}
//After the foreach

$encoded_msg = substr($encoded_msg, 0, -1);
//$encoded_msg .= '  ] 
//}';
echo $encoded_msg;
$conn->close();
?>








              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
