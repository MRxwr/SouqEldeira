<?php
include 'includes/checksouthead.php';
readSlug();
// Default OG values
$ogTitle = direction("Properties for sale and rent in Kuwait","عقارات للبيع والإيجار في الكويت");
$ogTitle .= (!empty($pageTitle) ? " | " . $pageTitle : ""); 
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
    } elseif ($_GET["v"] == "NewsView" && isset($_GET["id"])) {
        if ($news = selectDBNew("news", [$_GET['id']], "`id` = ? AND `status` = '0' AND `hidden` = '1'", "")) {
            $ogTitle = direction($news[0]['enTitle'], $news[0]['arTitle']);
            $ogDescription = direction($news[0]['enDetails'], $news[0]['arDetails']);
            if (!empty($news[0]['imageurl'])) {
                $ogImage = $baseURL . "logos/" . $news[0]['imageurl'];
            }
        }
    } elseif ($_GET["v"] == "NewsList") {
        $ogTitle = direction("News","الأخبار");
        $ogDescription = direction("Latest news on Souq Al Deirah","أحدث الأخبار في سوق الديرة");
    }
}

$ogUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Clean URL for hreflang to avoid duplicate lang parameters
$cleanUrl = preg_replace('/([?&])lang=[^&]*(&|$)/', '$1', $ogUrl);
$cleanUrl = preg_replace('/[?&]$/', '', $cleanUrl);
$hreflangSign = (strpos($cleanUrl, '?') !== false) ? '&' : '?';
$description = strip_tags($ogDescription);
$description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
$description = preg_replace('/\s+/u', ' ', trim($description));
$description = mb_substr($description, 0, 160, 'UTF-8');
$description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" dir="<?php echo $_SESSION['dir']; ?>">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?php echo $description; ?>" />
    <meta name="google-site-verification" content="uQF2UV0lQo1EKZCrPXcX_zUidNG_Zh8SIY3tctlP34M" />
    <meta name="author" content="" />
    <title><?php echo direction("Souq Al Deerah","سوق الديرة") . " | " . htmlspecialchars($ogTitle); ?></title>
    <link rel="canonical" href="<?php echo $ogUrl; ?>" />
    <link rel="alternate" hreflang="ar-KW" href="<?php echo $cleanUrl . $hreflangSign . "lang=ar"; ?>" />
    <link rel="alternate" hreflang="en-KW" href="<?php echo $cleanUrl . $hreflangSign . "lang=en"; ?>" />
    <link rel="alternate" hreflang="x-default" href="<?php echo $cleanUrl . $hreflangSign . "lang=en"; ?>" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title"
        content="<?php echo direction("Souq Al Deerah","سوق الديرة") . " | " . htmlspecialchars($ogTitle); ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:image" content="<?php echo $ogImage; ?>" />
    <meta property="og:url" content="<?php echo $ogUrl; ?>" />
    <meta property="og:type" content="website" />

    <link rel="manifest" href="/manifest.json" />

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/assets/img/logo-1.png" />
    <!-- Core CSS -->
    <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='ltr') { ?>
    <link
        href="/assets/components/bootstrap/v-5.2.3/css/bootstrap.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"
        rel="stylesheet" />
    <?php } ?>
    <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
    <link
        href="/assets/components/bootstrap/v-5.2.3/css/bootstrap.rtl.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"
        rel="stylesheet" />
    <?php } ?>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"
        rel="stylesheet" />
    <link
        href="/assets/components/bootstrap-modal/dist/bootstrap-side-modals.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"
        rel="stylesheet" />
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <?php } else { ?>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <?php } ?>
    <!-- Owl Stylesheets -->
    <link rel="stylesheet"
        href="/assets/components/owl-carousel/v-2.3.4/dist/assets/owl.carousel.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>">
    <link rel="stylesheet"
        href="/assets/components/owl-carousel/v-2.3.4/dist/assets/owl.theme.default.min.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>">
    <!-- Theme Css  -->
    <link href="/assets/css/style.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
    <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
    <link href="/assets/css/style-rtl.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
    <?php } ?>
    <link href="/assets/css/responsive.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>" rel="stylesheet" />
    <?php if(isset($_SESSION["dir"]) && $_SESSION["dir"]==='rtl') { ?>
    <link href="/assets/css/responsive-rtl.css?<?php echo randLetter() ?>=<?php echo $config['v'] ?>"
        rel="stylesheet" />
    <?php } ?>
    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-N4243KZJ');
    </script>
    <!-- End Google Tag Manager -->

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
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N4243KZJ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include 'template/navbar.php'; ?>
    <?php include 'template/sidebar.php'; ?>
    <!-- Start page-content -->
    <div class="page-content my-5">
        <div class="home page-header"></div>
        <div class="container container-project">