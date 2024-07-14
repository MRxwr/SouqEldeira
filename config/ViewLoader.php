<?php

function loadView($viewName='', $data = []){
    global $config;
    $viewPath='themes/'.$config['theme'].'/views/'.$viewName.'.php';
    return $viewPath;
    
}

?>
