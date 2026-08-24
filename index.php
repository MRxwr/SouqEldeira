<?php
ob_start();
require_once 'template/header.php';
require_once 'includes/SchemaBuilder.php';

if( isset($_GET["finalstatus"]) ){
	if( strtolower(base64_decode($_GET["finalstatus"])) == "success" ){
		$_GET["v"] = "Payment";
		$_GET["success"] = 1;
	}else{
		$_GET["v"] = "Payment";
		$_GET["error"] = 1;
	}
}

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	$currentView = $_GET["v"];
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	$currentView = "Home";
	require_once("views/bladeHome.php");
}

SchemaBuilder::renderForPage($currentView, get_defined_vars());

require_once 'template/footer.php';
ob_end_flush();
?>