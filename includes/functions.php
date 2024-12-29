<?php
 function getMyAds($id, $tp='expired'){
    if($tp == 'expired'){
        $date = date("Y-m-d");
        $myads = selectDB("products"," `expiryDate` > '{$date}' AND `status` = '0' AND `userId` = '{$id}'");
    }else{
        $myads = selectDB("products"," `expiryDate` < '{$date}' AND `status` = '0' AND `userId` = '{$id}'");
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