<?php

require "init.php";

$message = $_POST['message'];
$title = $_POST['title'];
$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
$server_key = "";
$sql = "select fcm_token from fcm_info";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_row($result);
$key = $row[0];
/*
$headers = array(
	'Authorization:key=' .$server_key,
	'Content-Type:application/json'
	);

$fields = array('to'=>$key,
	'notification'=>array('title'=>$title,'body'=>$message));

*/
//echo $key;
//$payload = json_encode($fields);
$curl_session = curl_init();

$result = $con->query("SELECT fcm_token from fcm_info");
if($result->num_rows>0){
    while ($row = $result->fetch_object()) {
        foreach ($row as $r){
            //echo $r.'<br>';
	$headers = array(
	'Authorization:key=' .$server_key,
	'Content-Type:application/json'
	);

$fields = array('to'=>$r,
	'notification'=>array('title'=>$title,'body'=>$message));
$payload = json_encode($fields);
//echo "done</br>";
//echo $payload;


curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
curl_setopt($curl_session, CURLOPT_POST, true);
curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

$result2 = curl_exec($curl_session);

        }
    }
}

curl_close($curl_session);
mysqli_close($con);

echo "Message sent. </br></br> <font size='25'> <a href='android_notification.php'> Return to page </a> </font>";
?>
