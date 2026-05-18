<?php
 function getMyAds($id, $tp, $page){
    if($page < 1) $page = 1;
    if($page > 1){
        $from = ($page-1)*5;
    }else{
        $from = 0;
    }
    $limit = 5*$page;
    $date = date("Y-m-d");
    if($tp == 'expired'){
        $myads = selectDB("products"," `expiryDate` < '{$date}' AND `status` = '0'  AND `userId` = '{$id}' ORDER BY `id` DESC LIMIT {$from}, {$limit}");
    }else if($tp == 'active'){
        $date = date("Y-m-d");
        $myads = selectDB("products"," `expiryDate` >= '{$date}' AND `status` = '0'  AND `userId` = '{$id}' ORDER BY `id` DESC LIMIT {$from}, {$limit}");
    }else if($tp == 'favourite'){
        $myads = selectDB("products"," `status` = '0' AND `hidden` != '2'  AND `listOfUsers` LIKE '%{$id}%' ORDER BY `id` DESC LIMIT {$from}, {$limit}");
    }else{
        $myads = [];
    }
    return $myads;
 }
 function resizeImage($source, $destination, $width, $height) {
    // Get the original dimensions and file type
    list($originalWidth, $originalHeight, $type) = getimagesize($source);
    $imageType = image_type_to_mime_type($type);

    // Create an image resource based on the file type
    switch ($imageType) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            die('Unsupported image format!');
    }

    // Create a blank canvas for the resized image
    $resizedImage = imagecreatetruecolor($width, $height);

    // Maintain transparency for PNG and GIF
    if ($imageType == 'image/png' || $imageType == 'image/gif') {
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
    }

    // Resize the image
    imagecopyresampled(
        $resizedImage, $image, 
        0, 0, 0, 0, 
        $width, $height, 
        $originalWidth, $originalHeight
    );
    // Save the resized image
    switch ($imageType) {
        case 'image/jpeg':
            imagejpeg($resizedImage, $destination, 90);
            break;
        case 'image/png':
            imagepng($resizedImage, $destination);
            break;
        case 'image/gif':
            imagegif($resizedImage, $destination);
            break;
    }

    // Free memory
    imagedestroy($image);
    imagedestroy($resizedImage);
}
function uploadImageBannerown($imageLocation){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.imgur.com/3/upload',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($imageLocation)),
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Client-ID 386563124e58e6c'
	  ),
	));
	$response = json_decode(curl_exec($curl),true);
	curl_close($curl);
	if( isset($response["success"]) && $response["success"] == true ){
		$imageSizes = [""];//,"b","m"];
		for( $i = 0; $i < sizeof($imageSizes); $i++ ){
			// Your file
			$file = $response["data"]["link"];
			$newFile = str_lreplace(".","{$imageSizes[$i]}.",$file);
			//get File Name
			$fileTitle = str_replace("https://i.imgur.com/","",$newFile);
			$fileTitle = str_replace("{$imageSizes[$i]}.",".",$fileTitle);
			// Open the file to get existing content
			$data = file_get_contents($newFile);
			// New filei c
			$new = "logos/{$imageSizes[$i]}".$fileTitle;
			// Write the contents back to a new file
			file_put_contents($new, $data);
		}
		return $fileTitle; 
	}else{
		return "";
	}
}

function doPaymant($data , $price){
    if ( $price <= 0 ) {
        return "https://{$_SERVER['HTTP_HOST']}/index.php?v=Payment&result=CAPTURED&payment_id=0&requested_order_id={$data["orderId"]}";
    }else{
        if(!empty($data) && is_array($data) && $data){
            $mid = "mer23000173";
            $secretKey = "4653344";
            $paymentGatewayUrl = "https://api.bookeey.com/api/payment/requestLink";
            
            $txnRefNo = mt_rand(1000000000000000, 9999999999999999);
            $su = "https://souqeldeira.com/index.php";
            $fu = "https://souqeldeira.com/index.php";
            $amt = number_format($data["totalAmount"], 3, '.', '');
            $orderId = $data["orderId"];
            $rndnum = rand(10000,99999);
            
            // Hash calculation
            $hashData = "$mid|$txnRefNo|$su|$fu|$amt|GEN|$secretKey|$rndnum";
            $hashed = hash('sha512', $hashData);

            $postParams = [
                'Do_TxnDtl' => [[ "SubMerchUID" => $mid, "Txn_AMT" => $amt ]],
                'Do_TxnHdr' => [
                    "PayFor" => "ECom",
                    "Txn_HDR" => "$rndnum",
                    "PayMethod" => "knet",
                    "BKY_Txn_UID" => "",
                    "Merch_Txn_UID" => "$orderId",
                    "hashMac" => $hashed
                ],
                'Do_Appinfo' => [
                    "APPTyp" => "Web",
                    "OS" => "Web",
                    "DevcType" => "Web",
                    "IPAddrs" => $_SERVER['REMOTE_ADDR'],
                    "AppVer" => "2.0.0",
                    "UsrSessID" => session_id(),
                    "APIVer" => "2.0.0"
                ],
                'Do_PyrDtl' => [
                    "Pyr_MPhone" => $data["phone"],
                    "Pyr_Name" => $data["name"]
                ],
                'Do_MerchDtl' => [
                    "BKY_PRDENUM" => "ECom",
                    "FURL" => $fu,
                    "MerchUID" => $mid,
                    "SURL" => $su
                ],
                'DBRqst' => "PY_ECom",
                'Do_MoreDtl' => ["Cust_Data1" => "", "Cust_Data3" => "", "Cust_Data2" => ""]
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $paymentGatewayUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($postParams),
                CURLOPT_HTTPHEADER => ['Accept: application/json', 'Content-Type: application/json'],
                CURLOPT_SSL_VERIFYPEER => 0
            ]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($response, true);

            if( isset($res["PayUrl"]) && !empty($res["PayUrl"]) ){
                return $res["PayUrl"];
            }else{
                return false;
            } 
        }
    }
}