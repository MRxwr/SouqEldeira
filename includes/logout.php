<?php
include_once ("../admin/includes/config.php");
include_once ("../admin/includes/functions.php");
require_once ("../admin/includes/translate.php");
setcookie($cookieSession, "", time() - (86400*30 ), "/");
session_start ();
if ( session_destroy() ){
	header("Location: index.php?v=Home");
}
?>