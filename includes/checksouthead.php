<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require ("admin/includes/config.php");
require ("admin/includes/functions.php");
require ("admin/includes/language.php");
require ("admin/includes/translate.php");
require ("includes/functions.php");
if( isset($_GET["error"]) && $_GET["error"] == "status" && (!isset($_GET["v"]) || $_GET["v"] != "Login") ){
    header("Location: index.php?v=Login&error=status");
    die();
}
if( isset($_GET["error"]) && $_GET["error"] == "blocked" ){
    if (!isset($_GET["v"]) || $_GET["v"] != "Login") {
        header("Location: index.php?v=Login&error=blocked");
        die();
    }
}
if ( isset($_COOKIE[$cookieSession]) && !empty($_COOKIE[$cookieSession]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession];
	if ( $user = selectDBNew("users", [$svdva], "`keepMeAlive` LIKE ?", "")){
        if( $user[0]["status"] != 0 ){
            $_SESSION['valid'] = false;
            setcookie($cookieSession, "", time() - (86400*30 ), "/");
            session_destroy();
            updateDB("users",array("keepMeAlive" => ""),"`id` = '{$user[0]["id"]}'");
            header("Location: index.php?v=Login&error=status");die();
        }
        if( $user[0]["hidden"] != 0 ){
            $_SESSION['valid'] = false;
            setcookie($cookieSession, "", time() - (86400*30 ), "/");
            session_destroy();
            updateDB("users",array("keepMeAlive" => ""),"`id` = '{$user[0]["id"]}'");
            header("Location: index.php?v=Login&error=blocked");die();
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
        if( $user[0]["logo"] == "" ){
            $userDetails["logo"] = "assets/img/logo-1.png";
        }
		$_SESSION[$cookieSession] = $user[0]["email"];	
	}else{
        $_SESSION['valid'] = false;
        setcookie($cookieSession, "", time() - (86400*30 ), "/");
        session_destroy();
		header("Location: index.php?v=Login&error=login");die();
	}
}

$now = date("Y-m-d H:i:s");
updateDB("products", array("hidden" => "1"), "`hidden` = '0'");
updateDB("products", array("hidden" => "2"), "`hidden` = '1' AND `expiryDate` < '{$now}'");
