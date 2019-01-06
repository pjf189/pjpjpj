<?php 

  function redirect_to($dest="/"){
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $dest"); 
  }
  
  function redirect_back(){
  	header("Location: {$_SERVER['HTTP_REFERER']} "); 
  }
//Define autoloader
  function myautoload($className) {
	  $class_path = __DIR__ . '/' . $className . '.php'; 
	  if (file_exists($class_path )) {
	    require_once $class_path ;
	    return true;
	  }
	  return false;
  }
  spl_autoload_register('myautoload');
?>