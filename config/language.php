<?php
ob_start();
session_start();

$sourceLang  = 'en';


// Srart -> This data for change depended on project default language 

$defaultLang = 'en';
$defaultDir  = 'ltr';  

// $defaultLang = 'ar';
// $defaultDir  = 'rtl'; 
 
// End -> This data for change depended on project default language 

if (!empty($_GET["lang"])) 
{ 
    switch (strtolower($_GET["lang"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang']        = 'en';
			$_SESSION["dir"]         = 'ltr';  
			$_SESSION["sourceLang"]  = $sourceLang;  
            break;
        case "ar":
            //If the string is tr or TR
            $_SESSION['lang']        = 'ar';
			$_SESSION["dir"]         = 'rtl'; 
			$_SESSION["sourceLang"]  = $sourceLang;  
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang']        = $defaultLang;
			$_SESSION["dir"]         = $defaultDir; 
			$_SESSION["sourceLang"]  = $sourceLang;  
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"]) || empty($_SESSION["dir"])) {
    //Set default lang if there was no language
    $_SESSION["lang"]        = $defaultLang;
	$_SESSION["dir"]         = $defaultDir; 
	$_SESSION["sourceLang"]  = $sourceLang; 
    
} 


function Trans($file,$word) 
{
  $word = trim($word);
  
  /*
  if($_SESSION["lang"] === $_SESSION["sourceLang"])
  {
  	return $word;
  }
  else 
  {
     $data = include(__DIR__ . "/../lang/".$_SESSION["lang"]."/".$file.".php");
	 if(isset($data[$word]))
	 {
	 	return $data[$word];   
	 }
	 else 
	 {
		 return $word;
	 }
  }
  */
  
	$data = include(__DIR__ . "/../lang/".$_SESSION["lang"]."/".$file.".php");
    
	if(isset($data[$word]))
		return $data[$word];   
	else 
		return $word;

}


if(isset($_SESSION['valid']))
{
	
}
else 
{
	$_SESSION['valid'] = false;
}
