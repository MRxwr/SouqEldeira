<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$config =array();


//$config['v']='1.0';
$config['site_url'] = "http://localhost:8000/";
$config['v'] = strtotime("now");

$config['theme'] = "default";

?>