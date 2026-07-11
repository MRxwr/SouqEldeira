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
	GLOBAL $_SERVER;
	$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	$segments = explode('/', $request);

	switch ($segments[0]) {
		case 'about':
			$_GET['v'] = 'About'; 
			break;
		
		case 'add-ad':
			$_GET['v'] = 'AddAd'; 
			break;

		case 'edit-ad':
			$_GET['v'] = 'EditAd'; 
			break;

		case 'ads-list':
			$_GET['v'] = 'AdsList'; 
			break;

		case 'ad':
			$_GET['v'] = 'AdView';
			$_GET['id'] = (int)$segments[1];
			break;

		case 'contact':
			$_GET['v'] = 'Contact';
			break;

		case 'faq':
			$_GET['v'] = 'FAQ';
			break;

		case 'home':
			$_GET['v'] = 'Home';
			break;

		case 'login':
			$_GET['v'] = 'Login';
			break;

		case 'logout':
			$_GET['v'] = 'Logout';
			break;

		case 'my-ads':
			$_GET['v'] = 'MyAds'; 
			break;

		case 'my-ads-list':
			$_GET['v'] = 'MyAdsList'; 
			break;

		case 'notifications':
			$_GET['v'] = 'Notifications'; 
			break;

		case 'offices':
			$_GET['v'] = 'Offices'; 
			break;

		case 'office-view':
			$_GET['v'] = 'OfficeView';
			$_GET['id'] = (int)$segments[1];
			break;

		case 'payment':
			$_GET['v'] = 'Payment'; 
			break;

		case 'policy':
			$_GET['v'] = 'Policy'; 
			break;

		case 'profile':
			$_GET['v'] = 'Profile'; 
			break;
			
		case 'search':
			$_GET['v'] = 'Search';
			$_GET['type'] = $segments[1] ?? '';
			$_GET['area'] = $segments[2] ?? '';
			break;

		case 'terms':
			$_GET['v'] = 'Terms'; 
			break;

		case '':
			$_GET['v'] = 'Home';
			break;
	}
}

function slug($text){
    $text = trim($text);
    $text = preg_replace('/\s+/u', '-', $text);
    $text = preg_replace('/[^\p{Arabic}\p{L}\p{N}\-]/u', '', $text);
    return $text;
}

?>