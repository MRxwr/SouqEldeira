<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["time"]);
   
   $_SESSION["valid"] = false; 
   
   echo 'You have cleaned session';
   header('Refresh: 2; URL = index.php');
?>