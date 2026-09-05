<?php
require_once('includes/checksouthead.php');

header('Content-Type: application/json; charset=utf-8');

function editorUploadError($message, $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode(array('error' => $message));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    editorUploadError('Only POST requests are allowed.', 405);
}

if (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
    editorUploadError('No image was uploaded.');
}

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    editorUploadError('The image could not be uploaded.');
}

$maxFileSize = 10 * 1024 * 1024;
if ($_FILES['file']['size'] > $maxFileSize) {
    editorUploadError('The image must be 10 MB or smaller.');
}

$imageInfo = getimagesize($_FILES['file']['tmp_name']);
if ($imageInfo === false || !isset($imageInfo['mime'])) {
    editorUploadError('The selected file is not a valid image.');
}

$allowedTypes = array(
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp'
);

if (!isset($allowedTypes[$imageInfo['mime']])) {
    editorUploadError('Only JPG, PNG, GIF and WebP images are allowed.');
}

$uploadDirectory = dirname(__DIR__) . '/logos';
if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
    editorUploadError('The server image directory is not writable.', 500);
}

try {
    $randomName = bin2hex(random_bytes(16));
} catch (Exception $exception) {
    $randomName = sha1(uniqid(mt_rand(), true));
}

$fileName = 'editor-' . $randomName . '.' . $allowedTypes[$imageInfo['mime']];
$destination = $uploadDirectory . '/' . $fileName;

if (!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
    editorUploadError('The server could not save the uploaded image.', 500);
}

echo json_encode(array('location' => '/logos/' . $fileName));
?>
