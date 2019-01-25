<?php

$host = "localhost";
$dbname ="fcm_db";
$username = "root";
$password = "";

$db = new mysqli($host,$dbname,$username,$password);
if (mysqli_connect_errno())
{

}

?>
