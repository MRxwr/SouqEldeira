<?php
require ("admin/includes/config.php");
require ("admin/includes/functions.php");
require ("admin/includes/language.php");
require ("admin/includes/translate.php");
if ( isset($_COOKIE[$cookieSession]) && !empty($_COOKIE[$cookieSession]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession];
	if ( $user = selectDBNew("users", [$svdva], "`keepMeAlive` LIKE ? AND `hidden` != '2' AND `status` = '0'", "")){
        $_SESSION['valid'] = true;
        $userDetails = array(
            "id" => $user[0]["id"],
            "email" => $user[0]["email"],
            "name" => $user[0]["name"],
            "username" => $user[0]["username"],
            "logo" => $user[0]["logo"],
        );
		$_SESSION[$cookieSession] = $user[0]["email"];	
	}else{
        $_SESSION['valid'] = false;
		header("Location: index.php?v=Home&error=" . md5(rand(0000,9999)));die();
	}
}