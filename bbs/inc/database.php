<?php
try{
    $handle = new PDO("mysql:host=127.0.0.1;dbname=bbs;","root","root");
    $handle->query('set names utf8');
    $handle->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
}catch (PDOException $e){
	echo $e->getMessage() . '<br/>';
}
?>