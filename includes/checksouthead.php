<?php
require ("admin/includes/config.php");
require ("admin/includes/functions.php");
require ("admin/includes/language.php");
require ("admin/includes/translate.php");
if ( isset($_COOKIE[$cookieSession]) && !empty($_COOKIE[$cookieSession]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession];
	if ( $user = selectDBNew("users", [$svdva], "`keepMeAlive` LIKE ?", "")){
        if( $user[0]["status"] != 0 ){
            $_SESSION['valid'] = false;
            updateDB("users",array("keepMeAlive" => ""),"`id` = '{$user[0]["id"]}'");
            header("Location: index.php?v=Home&error=status");die();
        }
        if( $user[0]["hidden"] != 0 ){
            $_SESSION['valid'] = false;
            updateDB("users",array("keepMeAlive" => ""),"`id` = '{$user[0]["id"]}'");
            header("Location: index.php?v=Home&error=blocked");die();
        }
        $_SESSION['valid'] = true;
        $userDetails = array(
            "id" => $user[0]["id"],
            "email" => $user[0]["email"],
            "name" => $user[0]["name"],
            "username" => $user[0]["username"],
            "phone" => $user[0]["phone"],
            "facebook" => $user[0]["facebook"],
            "twitter" => $user[0]["twitter"],
            "instagram" => $user[0]["instagram"],
            "url" => $user[0]["url"],
            "contactEmail" => $user[0]["contactEmail"],
            "logo" => $user[0]["logo"],
        );
		$_SESSION[$cookieSession] = $user[0]["email"];	
	}else{
        $_SESSION['valid'] = false;
		header("Location: index.php?v=Home&error=login");die();
	}
}