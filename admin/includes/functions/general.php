<?php
// search for file name inside a folder \\
function searchFile($path, $fileName) {
	if ($handle = opendir($path)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry == $fileName) {
				closedir($handle);
				return $entry;
			}
		}
		closedir($handle);
	}
	return false;
}
// general \\
function direction($valEn,$valAr){
	GLOBAL $directionHTML;
	if ( $directionHTML == "rtl" ){
		$response = $valAr;
	}else{
		$response = $valEn;
	}
	return $response;
}

function generateRandomToken(){
	$bytes = date("Y-m-d H:i:s").time();
	return password_hash($bytes, PASSWORD_BCRYPT);
}

function errorResponse($lang, $valEn, $valAr){
	if ( $lang == "ar" ){
		$response = $valAr;
	}else{
		$response = $valEn;
	}
	return $response;
}

// select a randon letter \\
function randLetter() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
	$letter = $alphabet[rand(0, 25)];
	return $letter;
}

// get sgin for url \\
function getSign(){
	GLOBAL $_SERVER;
	if (strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '?') !== false) {
		return '&';
	} else {
		return '?';
	}
}

// get file extension \\
function getFileExtension($filePath) { 
    $dotPosition = strrpos($filePath, '.');
    $extension = ( $dotPosition === false ? '' : substr($filePath, $dotPosition + 1) );
    return $extension;
}

// change time zone \\
function timeZoneConverter($date){
	return date('Y-m-d H:i:s', strtotime($date) + 10800);
}

//add trailing zeros
function formatNumber($num) {
  return str_pad($num, 6, '0', STR_PAD_LEFT);
}

// convert numbers to 3 digits \\
function numTo3Float($data){
	$data = number_format((float)$data, 3);
	return $data;
}

// generating a random alphanumeric code of 8 characters \\
function generateRandomString() {
    $bytes = random_bytes(8);
    $hex   = bin2hex($bytes);
    return substr($hex, 0, 8);
}

// make sure that phone numbers are in english \\
function convertMobileNumber($phone){
	$arabic = ['١','٢','٣','٤','٥','٦','٧','٨','٩','٠'];
	$english = [ 1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 , 0];
	$phone = str_replace($arabic, $english, $phone);
	return $phone;
}

// validating emal address \\
function validateEmail($email){
	GLOBAL $settingsEmail;
	if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ){
	  return $settingsEmail;
	}else{
	  return $email;
	}
}

// generating automatic orderId \\
function generateOrderId(){
	if($orders = selectDB("orders2", "`id` != '' ORDER BY `id` DESC")){
		$newOrderNumber = (int)$orders[0]["orderId"] + 1;
	}else{
		$newOrderNumber = 1;
	}
	return $newOrderNumber;
}

// showing the response in a json form \\
function outputData($data){
	$response["ok"] = true;
	$response["error"] = "0";
	$response["status"] = "successful";
	$response["data"] = $data;
	return json_encode($response);
}

// showing erros in json form \\
function outputError($data){
	$response["ok"] = false;
	$response["error"] = "1";
	$response["status"] = "Error";
	$response["data"] = $data;
	return json_encode($response);
}

// resoring arrays of multiple dimensions \\
function array_sort($array, $on, $order){
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0){
        foreach ($array as $k => $v){
            if (is_array($v)){
                foreach ($v as $k2 => $v2){
                    if ($k2 == $on){
                        $sortable_array[$k] = $v2;
                    }
                }
            }else{
                $sortable_array[$k] = $v;
            }
        }
        switch($order){
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v){
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}


function str_lreplace($search, $replace, $subject){
    $pos = strrpos($subject, $search);
    if($pos !== false){
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}

function readSlug(){
	GLOBAL $_SERVER, $pageTitle;
	$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	$segments = explode('/', $request);
	$pageTitle = "";
	switch ($segments[0]) {
		case 'about':
			$_GET['v'] = 'About';
			$pageTitle = direction("About Us","من نحن");
			break;
		
		case 'add-ad':
			$_GET['v'] = 'AddAd'; 
			$pageTitle = direction("Add Ad","إضافة إعلان");
			break;

		case 'edit-ad':
			$_GET['v'] = 'EditAd'; 
			$pageTitle = direction("Edit Ad","تحديث الإعلان");
			$_GET["id"] = (int)$segments[1];
			break;

		case 'ads-list':
			$_GET['v'] = 'AdsList'; 
			$pageTitle = direction("Ads List","قائمة الإعلانات");
			$_GET["type"] = (int)$segments[1];
			break;

		case 'ad-view':
			$_GET['v'] = 'AdView';
			$pageTitle = direction("Ad View","عرض الإعلان");
			$_GET['id'] = (int)$segments[1];
			break;

		case 'news-list':
			$_GET['v'] = 'NewsList';
			$pageTitle = direction("News List","قائمة الأخبار");
			$_GET['page'] = (int)($segments[1] ?? 1);
			break;

		case 'news-view':
			$_GET['v'] = 'NewsView';
			$pageTitle = direction("News View","عرض الأخبار");
			$_GET['id'] = (int)$segments[1];
			break;
		
		case 'contact':
			$_GET['v'] = 'Contact';
			$pageTitle = direction("Contact Us","اتصل بنا");
			break;

		case 'faq':
			$_GET['v'] = 'FAQ';
			$pageTitle = direction("FAQ","الاسئلة الشائعة");
			break;

		case 'home':
			$_GET['v'] = 'Home';
			$pageTitle = direction("Home","الصفحة الرئيسية");
			break;

		case 'login':
			$_GET['v'] = 'Login';
			$pageTitle = direction("Login","تسجيل الدخول");
			break;

		case 'reset-phone':
			$_GET['v'] = 'Login';
			$pageTitle = "";
			$_GET['reset'] = 'phone';
			break;

		case 'logout':
			$_GET['v'] = 'Logout';
			$pageTitle = direction("Logout","تسجيل الخروج");
			break;

		case 'my-ads':
			$_GET['v'] = 'MyAds'; 
			$pageTitle = direction("My Ads","الإعلانات الخاصة بي");
			break;

		case 'my-ads-list':
			$_GET['v'] = 'MyAdsList'; 
			$pageTitle = direction("My Ads List","قائمة الإعلانات الخاصة بي");
			break;

		case 'my-ads-list-type':
			$_GET['v'] = 'MyAdsList'; 
			$pageTitle = direction("My Ads List","قائمة الإعلانات الخاصة بي");
			$_GET["type"] = "{$segments[1]}" ?? '';
			$_GET["page"] = (int)($segments[2] ?? 1);
			break;

		case 'my-ads-error':
			$_GET['v'] = 'MyAds'; 
			$pageTitle = direction("My Ads","الإعلانات الخاصة بي");
			$_GET["error"] = (int)$segments[1];
			break;

		case 'my-ads-delete':
			$_GET['v'] = 'MyAds'; 
			$pageTitle = direction("My Ads","الإعلانات الخاصة بي");
			$_GET["forceDelete"] = (int)$segments[1];
			break;

		case 'my-ads-remove':
			$_GET['v'] = 'MyAds'; 
			$pageTitle = direction("My Ads","الإعلانات الخاصة بي");
			$_GET["remove"] = (int)$segments[1];
			break;

		case 'my-ads-success':
			$_GET['v'] = 'MyAds'; 
			$pageTitle = direction("My Ads","الإعلانات الخاصة بي");
			$_GET["success"] = (int)$segments[1];
			break;

		case 'notifications':
			$_GET['v'] = 'Notifications'; 
			$pageTitle = direction("Notifications","الإشعارات");
			break;

		case 'offices':
			$_GET['v'] = 'Offices'; 
			$pageTitle = direction("Offices","المكاتب");
			break;

		case 'office-view':
			$_GET['v'] = 'OfficeView';
			$pageTitle = direction("Office View","عرض المكتب");
			$_GET['id'] = (int)$segments[1];
			break;

		case 'payment':
			$_GET['v'] = 'Payment';
			$pageTitle = direction("Payment","الدفع");
			break;

		case 'payment-error':
			$_GET['v'] = 'Payment'; 
			$pageTitle = direction("Payment Error","خطأ في الدفع");
			$_GET["error"] = "1";
			break;

		case 'policy':
			$_GET['v'] = 'Policy'; 
			$pageTitle = direction("Privacy Policy","سياسة الخصوصية");
			break;

		case 'profile':
			$_GET['v'] = 'Profile'; 
			$pageTitle = direction("Profile","الملف الشخصي");
			break;
			
		case 'search':
			$_GET['v'] = 'Search';
			$pageTitle = direction("Search","بحث");
			// /search/{category-title}/{area-title}/{property-type-title}
			$_GET['searchPath'] = implode('/', array_slice($segments, 1));
			break;

		case 'terms':
			$_GET['v'] = 'Terms'; 
			$pageTitle = direction("Terms & Conditions","الشروط والأحكام");
			break;

		case '':
			$_GET['v'] = 'Home';
			$pageTitle = direction("Home","الصفحة الرئيسية");
			break;
	}
}

function slug($text){
    $text = trim($text);
    $text = preg_replace('/\s+/u', '-', $text);
    $text = preg_replace('/[^\p{Arabic}\p{L}\p{N}\-]/u', '', $text);
    return $text;
}

// Date of a row for <lastmod>, or an empty string when the row has none \\\
function sitemapLastmod($date) {
    $time = !empty($date) ? strtotime($date) : false;
    return $time ? date("Y-m-d", $time) : "";
}

// One <url> block of the sitemap. $alternates holds hreflang => absolute url \\\
function sitemapUrlBlock($loc, $alternates = array(), $lastmod = "", $changefreq = "weekly", $priority = "0.5") {
    $xml = '  <url>' . PHP_EOL;
    $xml .= '    <loc>' . htmlspecialchars($loc, ENT_QUOTES, 'UTF-8') . '</loc>' . PHP_EOL;
    if (!empty($lastmod)) {
        $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
    }
    $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
    $xml .= '    <priority>' . $priority . '</priority>' . PHP_EOL;
    foreach ($alternates as $hreflang => $href) {
        $xml .= '    <xhtml:link rel="alternate" hreflang="' . $hreflang . '" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }
    $xml .= '  </url>' . PHP_EOL;
    return $xml;
}

/**
 * Both language versions of a page that has its own url per language.
 * $paths holds the path of the page for every language, each url is written
 * with the same set of alternates so the search engines pair them together.
 */
function sitemapLanguageUrls($base, $paths, $lastmod = "", $changefreq = "weekly", $priority = "0.5") {
    $links = array(
        "ar-KW"     => $base . ltrim($paths["ar"], "/"),
        "en-KW"     => $base . ltrim($paths["en"], "/"),
        "x-default" => $base . ltrim($paths["en"], "/")
    );
    $xml = "";
    foreach (array("ar", "en") as $lang) {
        $xml .= sitemapUrlBlock($base . ltrim($paths[$lang], "/"), $links, $lastmod, $changefreq, $priority);
    }
    return $xml;
}

function updateSitemap() {
    global $baseURL;

    // The urls of the pages that carry a title inside them are built in one place
    if (!class_exists("SeoUrls")) {
        require_once dirname(__DIR__, 3) . "/includes/SeoUrls.php";
    }

    // Ensure baseURL ends with /
    $base = rtrim($baseURL, "/") . "/";

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . PHP_EOL;

    // Pages keeping a single url, the visitor language comes from the cookie
    $xml .= sitemapUrlBlock($base, array(), "", "daily", "1.0");
    $xml .= sitemapUrlBlock($base . "news-list/1", array(), "", "daily", "0.8");
    $xml .= sitemapUrlBlock($base . "offices", array(), "", "weekly", "0.7");

    // Search result pages: one url per category and language
    if ($categories = selectDB("categories", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")) {
        foreach ($categories as $category) {
            $xml .= sitemapLanguageUrls($base, array(
                "ar" => SeoUrls::searchUrl($category, 0, "", "", "", "ar"),
                "en" => SeoUrls::searchUrl($category, 0, "", "", "", "en")
            ), "", "daily", "0.9");
        }
    }

    // Real estate offices
    if ($offices = selectDB("shops", "`status` = '0' ORDER BY `rank` ASC")) {
        foreach ($offices as $office) {
            $xml .= sitemapLanguageUrls($base, array(
                "ar" => SeoUrls::titleUrl("office-view", $office["id"], $office["enTitle"], $office["arTitle"], "ar"),
                "en" => SeoUrls::titleUrl("office-view", $office["id"], $office["enTitle"], $office["arTitle"], "en")
            ), "", "weekly", "0.7");
        }
    }

    // Individual ads
    if ($products = selectDB("products", "`status` = '0' AND `hidden` = '1' ORDER BY `id` DESC")) {
        foreach ($products as $product) {
            $xml .= sitemapLanguageUrls($base, array(
                "ar" => SeoUrls::titleUrl("ad-view", $product["id"], $product["enTitle"], $product["arTitle"], "ar"),
                "en" => SeoUrls::titleUrl("ad-view", $product["id"], $product["enTitle"], $product["arTitle"], "en")
            ), sitemapLastmod($product["date"]), "weekly", "0.6");
        }
    }

    // News
    if ($newsList = selectDB("news", "`status` = '0' AND `hidden` = '1' ORDER BY `id` DESC")) {
        foreach ($newsList as $news) {
            $xml .= sitemapLanguageUrls($base, array(
                "ar" => SeoUrls::titleUrl("news-view", $news["id"], $news["enTitle"], $news["arTitle"], "ar"),
                "en" => SeoUrls::titleUrl("news-view", $news["id"], $news["enTitle"], $news["arTitle"], "en")
            ), sitemapLastmod($news["date"]), "weekly", "0.8");
        }
    }

    $xml .= '</urlset>' . PHP_EOL;

    // admin/includes/functions/general.php -> goes up 3 levels to reach the site root
    file_put_contents(dirname(__DIR__, 3) . "/sitemap.xml", $xml);
}

?>