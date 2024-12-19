<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$config =array();
$config['v'] = strtotime("now");
$config['theme'] = "default";

$servername = "localhost";
$usernameDB = "u800348178_myacad2USER";
$password = "N@b$90949089";
$dbname = "u800348178_myacadv2DB";
$baseURL = "https://myacad.app/requests";
$printImageUrl = "https://myacad.app";
$dbconnect = new MySQLi($servername,$usernameDB,$password,$dbname);
if ( $dbconnect->connect_error ){
	die("Connection Failed: " .$dbconnect->connect_error );
}
$sql = "SET CHARACTER SET utf8";
$dbconnect->query($sql);

?>