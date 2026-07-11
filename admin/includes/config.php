<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$config =array();
$config['v'] = strtotime("now");
$config['theme'] = "default";

$servername = "localhost";
$usernameDB = "u671249433_souqeldeiraU";
$password = "N@b$90949089";
$dbname = "u671249433_souqeldeiraD";
$baseURL = "https://souqeldeira.createkwservers.com/";
$printImageUrl = "https://souqeldeira.createkwservers.com/";
$dbconnect = new MySQLi($servername,$usernameDB,$password,$dbname);
if ( $dbconnect->connect_error ){
	die("Connection Failed: " .$dbconnect->connect_error );
}
$dbconnect->set_charset("utf8mb4");
?>