<?php include 'config/config.php'; ?>
<?php include 'config/language.php'; ?>
<?php include 'config/lang-js.php'; ?>
<?php 
  include 'config/ViewLoader.php';
  // Get the protocol (http or https)
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
  // Get the host
   $host = $_SERVER['HTTP_HOST'];
  // Get the current path
 // Get the current URL path
$currentUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

if ($currentUrl === '/') {
    // If the URL is the root, set the page to 'home'
    $page = 'home';
} else {
    // Parse the URL to get the path
    $urlParts = parse_url($currentUrl);
    $path = isset($urlParts['path']) ? $urlParts['path'] : '';

    // Get the last segment of the path
    $segments = explode('/', rtrim($path, '/'));
    $page = end($segments);

    // Ensure the page is not empty (handles cases where URL ends with /)
    if (empty($page)) {
        $page = 'home'; // Set to default page if empty
    }
}

// Format the page name correctly
$page = ucfirst($page);
$page = str_replace(' ', '', ucwords(str_replace('-', ' ', $page)));

// Include the corresponding component
include 'src/components/' . $page . 'Components.php';
exit;
?>