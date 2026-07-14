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
			$_GET['title'] = $segments[1] ?? '';
			$_GET['type'] = $segments[2] ?? '';
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

function updateSitemap() {
    global $dbconnect, $baseURL;
    
    // Ensure baseURL ends with /
    $base = rtrim($baseURL, "/") . "/";
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Home Page
    $xml .= '  <url>' . PHP_EOL;
    $xml .= '    <loc>' . $base . '</loc>' . PHP_EOL;
    $xml .= '    <changefreq>daily</changefreq>' . PHP_EOL;
    $xml .= '    <priority>1.0</priority>' . PHP_EOL;
    $xml .= '  </url>' . PHP_EOL;

    // Categories
    if ($categories = selectDB("categories", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")) {
        foreach ($categories as $cat) {
            $slugTitle = slug($cat["arTitle"]);
            if (empty($slugTitle)) $slugTitle = slug($cat["enTitle"]);
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . $base . 'search/' . urldecode($slugTitle) . '/' . $cat["id"] . '</loc>' . PHP_EOL;
            $xml .= '    <changefreq>daily</changefreq>' . PHP_EOL;
            $xml .= '    <priority>0.9</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
    }
    
    // Property Types
    if ($propertyTypes = selectDB("propertyType", "`status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")) {
        foreach ($propertyTypes as $type) {
            $slugTitle = slug($type["arTitle"]);
            if (empty($slugTitle)) $slugTitle = slug($type["enTitle"]);
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . $base . 'search/' . urldecode($slugTitle) . '/' . $type["id"] . '</loc>' . PHP_EOL;
            $xml .= '    <changefreq>daily</changefreq>' . PHP_EOL;
            $xml .= '    <priority>0.8</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
    }

    // Offices
    if ($offices = selectDB("shops", "`status` = '0'")) {
        foreach ($offices as $office) {
            $slugTitle = slug($office["arTitle"]);
            if (empty($slugTitle)) $slugTitle = slug($office["enTitle"]);
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . $base . 'office-view/' . $office["id"] . '/' . urldecode($slugTitle) . '</loc>' . PHP_EOL;
            $xml .= '    <changefreq>weekly</changefreq>' . PHP_EOL;
            $xml .= '    <priority>0.7</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
    }

    // Individual Ads
    if ($products = selectDB("products", "`status` = '0' AND `hidden` = '1' ORDER BY `id` DESC")) {
        foreach ($products as $product) {
            $slugTitle = slug($product["arTitle"]);
            if (empty($slugTitle)) $slugTitle = slug($product["enTitle"]);
            $lastmod = date("Y-m-d", strtotime($product["date"]));
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . $base . 'ad-view/' . $product["id"] . '/' . urldecode($slugTitle) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>weekly</changefreq>' . PHP_EOL;
            $xml .= '    <priority>0.6</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }
    }

    $xml .= '</urlset>';

    // Determine root directory to save sitemap.xml
    // admin/includes/functions/general.php -> goes up 3 levels to reach root
    $sitemapPath = dirname(__DIR__, 2) . "/sitemap.xml";
    if (!file_exists($sitemapPath)) {
        $sitemapPath = dirname(__DIR__, 3) . "/sitemap.xml";
    }
    file_put_contents($sitemapPath, $xml);
}

?>