<?php


$host = "mycolvps";
$db_user = "root";
$db_password = "";
$db_name = "fcm_db";


$con = mysqli_connect($host,$db_user,$db_password,$db_name);
if(mysqli_connect_errno)
{
	printf("Connect failed: %d\n", mysqli_connect_error());
        exit();
}
?>
