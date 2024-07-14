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
  $currentUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
 if(isset($currentUrl) && $currentUrl =='/'){
	$page ='home';
	$page = ucfirst($page);
	$page = str_replace(' ', '', ucwords(str_replace('-', ' ', $page)));
	include 'src/components/'.$page.'Components.php';
	exit;
 }else{
	$urlParts = parse_url($currentUrl);
	// Extract the path from the URL
	$path = isset($urlParts['path']) ? $urlParts['path'] : '';
	// Get the last segment of the path
	$segments = explode('/', rtrim($path, '/'));
	$page = end($segments);
	$page = ucfirst($page);
	$page = str_replace(' ', '', ucwords(str_replace('-', ' ', $page)));
	include 'src/components/'.$page.'Components.php';
	exit;
		
}
?>