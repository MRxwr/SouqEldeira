<?php 
require_once '../admin/includes/config.php';
require_once '../admin/includes/functions.php';

// get viewed page from pages folder \\
if( isset($_GET["a"]) && searchFile("views","api{$_GET["a"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["a"]}.php"));
}else{
	echo outputError(array("msg" => "API not found"));die();
}

?>