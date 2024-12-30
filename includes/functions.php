<?php
 function getMyAds($id, $tp){
    $date = date("Y-m-d");
    if($tp == 'expired'){
        $myads = selectDB("products"," `expiryDate` < '{$date}' AND `status` = '0'  AND `userId` = '{$id}'");
    }else{
        $date = date("Y-m-d");
        $myads = selectDB("products"," `expiryDate` >= '{$date}' AND `status` = '0'  AND `userId` = '{$id}'");
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
/*
function uploadImageBannerown($tmpFilePath, $uploadDir = 'logos/')
{
    // Ensure the upload directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory with necessary permissions
    }

    // Generate a unique name for the file to avoid conflicts
    $fileExtension = pathinfo($tmpFilePath, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('banner_', true) . '.' . $fileExtension;
    $targetPath = $uploadDir . $uniqueFileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($tmpFilePath, $targetPath)) {
        return $uniqueFileName; // Return the new file name
    } else {
        return false; // Return false if the upload fails
    }
}
*/
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
