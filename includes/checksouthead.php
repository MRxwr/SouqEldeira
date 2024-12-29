<?php
require ("admin/includes/config.php");
require ("admin/includes/functions.php");
require ("admin/includes/language.php");
require ("admin/includes/translate.php");
if( isset($_GET["error"]) && $_GET["error"] == "status" ){
    $msg = direction("Your account is blocked", "تم حظر حسابك");
    ?>
    <script>
        alert("<?php echo $msg; ?>");
        window.location = "index.php?v=Home";
    </script>
    <?php
}
if( isset($_GET["error"]) && $_GET["error"] == "blocked" ){
    $msg = direction("Your account is locked", "تم قفل حسابك");
    ?>
    <script>
        alert("<?php echo $msg; ?>");
        window.location = "index.php?v=Home";
    </script>
    <?php
}
if ( isset($_COOKIE[$cookieSession]) && !empty($_COOKIE[$cookieSession]) ){
	session_start ();
	$svdva = $_COOKIE[$cookieSession];
	if ( $user = selectDBNew("users", [$svdva], "`keepMeAlive` LIKE ?", "")){
        if( $user[0]["status"] != 0 ){
			$msg = direction("Your account is blocked", "تم حظر حسابك");
			?>
			<script>
				alert("<?php echo $msg; ?>");
				window.location = "index.php?v=Home";
			</script>
			<?php
            $_SESSION['valid'] = false;
            setcookie($cookieSession, "", time() - (86400*30 ), "/");
            session_destroy();
            updateDB("users",array("keepMeAlive" => ""),"`id` = '{$user[0]["id"]}'");
            header("Location: index.php?v=Home&error=status");die();
        }
        if( $user[0]["hidden"] != 0 ){
			$msg = direction("Your account is locked", "تم قفل حسابك");
			?>
			<script>
				alert("<?php echo $msg; ?>");
				window.location = "index.php?v=Home";
			</script>
			<?php
            $_SESSION['valid'] = false;
            setcookie($cookieSession, "", time() - (86400*30 ), "/");
            session_destroy();
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
        if( $user[0]["logo"] == "" ){
            $userDetails["logo"] = "assets/img/logo-1.png";
        }
		$_SESSION[$cookieSession] = $user[0]["email"];	
	}else{
        $_SESSION['valid'] = false;
        setcookie($cookieSession, "", time() - (86400*30 ), "/");
        session_destroy();
		header("Location: index.php?v=Home&error=login");die();
	}
}