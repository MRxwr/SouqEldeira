<?php 
require_once '../template/header.php';

// get viewed page from pages folder \\
if( isset($_GET["a"]) && searchFile("views","api{$_GET["a"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["a"]}.php"));
}else{
	echo outputError(array("msg" => "API not found"));die();
}

require_once '../template/footer.php';
?>