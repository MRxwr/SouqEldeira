<?php
include 'includes/checksouthead.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo $_SESSION['dir']; ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo direction("Souq Al Deerah","سوق الديرة"); ?></title>
        <!-- Favicon-->
        <link rel="icon" type="assets/image/x-icon" href="assets/img/logo-1.png" />
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