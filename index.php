<?php 
require_once 'template/header.php';
if( isset($_GET["finalstatus"]) ){
	if( base64_decode($_GET["finalstatus"]) == "Failure" ){
		$_GET["v"] = "Payment";
		$_GET["error"] = 1;
	}else{
		$_GET["v"] = "Payment";
		$_GET["success"] = 1;
	}
}

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	require_once("views/bladeHome.php");
}

require_once 'template/footer.php';
?>