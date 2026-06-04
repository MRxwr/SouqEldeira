<?php
include 'includes/checksouthead.php';

// Default OG values
$ogTitle = direction("Souq Al Deerah","سوق الديرة");
$ogDescription = direction("Souq Al Deerah website for ads", "موقع سوق الديرة للإعلانات"); 
$ogImage = $baseURL . "assets/img/logo-1.png";

if ( $settings = selectDB("settings","`id` = '1'") ){
    if (!empty($settings[0]["OgDescription"])) {
        $ogDescription = $settings[0]["OgDescription"];
    }
    if (!empty($settings[0]["logo"])) {
        $ogImage = $baseURL . "logos/" . $settings[0]["logo"];
    }
}

// Page specific overrides
if (isset($_GET["v"])) {
    if ($_GET["v"] == "AdView" && isset($_GET["id"])) {
        if ($ad = selectDBNew("products", [$_GET['id']], "`id` = ?", "")) {
            $ogTitle = direction($ad[0]['enTitle'], $ad[0]['arTitle']);
            $ogDescription = direction($ad[0]['enDetails'], $ad[0]['arDetails']);
            if ($images = selectDB("images", "`productId` = '" . $ad[0]['id'] . "'")) {
                $ogImage = $baseURL . "logos/" . $images[0]["imageurl"];
            }
        }
    } elseif ($_GET["v"] == "OfficeView" && isset($_GET["id"])) {
        if ($offices = selectDBNew("shops", [$_GET["id"]], "`id` = ? AND `status` = '0'", "")) {
            $ogTitle = direction($offices[0]["enTitle"], $offices[0]["arTitle"]);
            $ogDescription = direction($offices[0]["enDetails"], $offices[0]["arDetails"]);
            if (!empty($offices[0]["logo"])) {
                $ogImage = $baseURL . "logos/" . $offices[0]["logo"];
            }
        }
    }
}

$ogUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo $_SESSION['dir']; ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?php echo htmlspecialchars(strip_tags($ogDescription)); ?>" />
        <meta name="author" content="" />
        <title><?php echo direction("Souq Al Deerah","سوق الديرة"); ?></title>

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle); ?>" />
        <meta property="og:description" content="<?php echo htmlspecialchars(strip_tags($ogDescription)); ?>" />
        <meta property="og:image" content="<?php echo $ogImage; ?>" />
        <meta property="og:url" content="<?php echo $ogUrl; ?>" />
        <meta property="og:type" content="website" />

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/img/logo-1.png" />
        <!-- Core CSS -->
        <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='ltr') { ?>
        <link href="assets/components/bootstrap/v-5.2.3/css/bootstrap.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
        <?php } ?>
         <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
        <link href="assets/components/bootstrap/v-5.2.3/css/bootstrap.rtl.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
        <?php } ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
        <link href="assets/components/bootstrap-modal/dist/bootstrap-side-modals.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
        <!-- Owl Stylesheets -->
    	<link rel="stylesheet" href="assets/components/owl-carousel/v-2.3.4/dist/assets/owl.carousel.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>">
    	<link rel="stylesheet" href="assets/components/owl-carousel/v-2.3.4/dist/assets/owl.theme.default.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>">
        <!-- Theme Css  -->
		<link href="assets/css/style.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
        <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
     	<link href="assets/css/style-rtl.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
    	<?php } ?>
    	<link href="assets/css/responsive.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
    	<?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
     	<link href="assets/css/responsive-rtl.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
    	<?php } ?>
    </head>
    <body>
	<!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->
        <?php include 'template/navbar.php'; ?> 
        <?php include 'template/sidebar.php'; ?> 
        <!-- Start page-content -->
		<div class="page-content my-5">
            <div class="home page-header"></div>
	        <div class="container container-project">